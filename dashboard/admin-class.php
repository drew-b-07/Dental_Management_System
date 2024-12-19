<?php 
require_once __DIR__.'/../database/dbconnection.php';
require_once __DIR__.'/../config/settings-configuration.php';
require_once __DIR__.'/../src/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ADMIN 
{
    private $conn; 
    private $settings;
    private $smtp_email;
    private $smtp_password;

    public function __construct()
    {
        $this->settings = new SystemConfig();
        $this->smtp_email = $this->settings->getSmtpEmail();
        $this->smtp_password = $this->settings->getSmtpPassword();

        $database = new Database();
        $this->conn = $database->dbConnection();
    }

    function send_email($email, $message, $subject, $smtp_email, $smtp_password)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->addAddress($email);
        $mail->Username = $smtp_email;
        $mail->Password = $smtp_password;
        $mail->setFrom($smtp_email, "Joanna");
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->send(); 
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit; 
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function resetPassword($token, $new_password, $csrf_token)
    {
        if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            echo "<script>alert('Invalid CSRF token.'); window.location.href = '../reset-password.php?token=$token'; </script>";
            exit;
        }
        unset($_SESSION['csrf_token']);

        $stmt = $this->runQuery("UPDATE admin SET password = :password WHERE token = :token");
        $stmt->execute([':password' => $new_password, ':token' => $token]);
        
        echo "<script>alert('Password reset successfully.'); window.location.href = '../';</script>";
        exit;
    }

    public function addAppointments($pName, $pAge, $pBday, $pGender, $pEmail, $pAddress, $pCondition, $pContact)
    {
        try {
            $stmt = $this->runQuery("INSERT INTO add_appointments 
                (patient_name, patient_age, patient_bday, patient_gender, patient_email, patient_address, patient_condition, patient_contact) 
                VALUES (:patient_name, :patient_age, :patient_bday, :patient_gender, :patient_email, :patient_address, :patient_condition, :patient_contact)");
            
            if ($stmt->execute([
                ':patient_name' => $pName,
                ':patient_age' => $pAge,
                ':patient_bday' => $pBday,
                ':patient_gender' => $pGender,
                ':patient_email' => $pEmail,
                ':patient_address' => $pAddress,
                ':patient_condition' => $pCondition,
                ':patient_contact' => $pContact
            ])) {
                echo 'Record Inserted Successfully!';
                header('Location: ./admin/index.php');
                exit;
            } else {
                echo "Failed to insert record.";
            }
        } catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getPatients() {
        try {
            $stmt = $this->runQuery("SELECT * FROM add_appointments");
            $stmt->execute();
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            $totalPatients = count($patients);
            
            
            return ['patients' => $patients, 'total' => $totalPatients];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return ['patients' => [], 'total' => 0]; 
        }
    }

    public function getUsersList() {
        try {
            
            $stmt = $this->runQuery("SELECT * FROM user");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $totalUsers = count($users);
            
            return ['users' => $users, 'total' => $totalUsers];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return ['users' => [], 'total' => 0];
        }
    }
    
    public function updateUser($data) {
        try {
            if (empty($data['user_id'])) {
                return ['success' => false, 'message' => 'User ID is required'];
            }
    
            $sql = "UPDATE user SET 
                fullname = ?, 
                email = ?, 
                username = ?,
                verify_status = ?";
    
            $params = [
                $data['fullname'],
                $data['email'],
                $data['username'],
                $data['verify_status']
            ];
            
            
            $passwordUpdate = $this->handlePasswordUpdate($data);
            if (!$passwordUpdate['success']) {
                return $passwordUpdate;
            }
    
            if ($passwordUpdate['hash']) {
                $sql .= ", password = ?";
                $params[] = $passwordUpdate['hash'];
            }
    
            $sql .= " WHERE id = ?";
            $params[] = $data['user_id'];
    
            
            if ($this->isEmailTaken($data['email'], $data['user_id'])) {
                return ['success' => false, 'message' => 'Email already taken. Please try another one'];
            }
    
            
            if ($this->isUsernameTaken($data['username'], $data['user_id'])) {
                return ['success' => false, 'message' => 'Username is already used'];
            }
    
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute($params);
    
            if ($result) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error updating user'];
            }
        } catch (PDOException $ex) {
            error_log('User Update Error: ' . $ex->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        }
    }
    
    private function handlePasswordUpdate($data) {
        if (empty($data['password'])) {
            return ['success' => true, 'hash' => null];
        }
    
        if (strlen($data['password']) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters long'];
        }
    
        $hashed_password = md5($data['password']);
        return ['success' => true, 'hash' => $hashed_password];
    }
    
    private function isEmailTaken($email, $userId) {
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE email = ? AND id != ?");
        $stmt->execute([$email, $userId]);
        return $stmt->rowCount() > 0;
    }
    
    private function isUsernameTaken($username, $userId) {
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        $stmt->execute([$username, $userId]);
        return $stmt->rowCount() > 0;
    }
    

    public function deleteUser($userId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM user WHERE id = ?");
            
            $result = $stmt->execute([$userId]);
            
            return $result 
                ? ['success' => true] 
                : ['success' => false, 'message' => 'Error deleting user'];
        } catch (PDOException $ex) {
            return ['success' => false, 'message' => $ex->getMessage()];
        }
    }


    public function updatePatient($data) {
        
        $formattedBday = date('Y-m-d', strtotime($data['patient_bday']));
        
        
        $stmt = $this->conn->prepare("UPDATE add_appointments SET 
            patient_name = ?, 
            patient_age = ?, 
            patient_bday = ?, 
            patient_gender = ?, 
            patient_email = ?, 
            patient_address = ?, 
            patient_condition = ?, 
            patient_contact = ? 
            WHERE id = ?");
        
        
        $result = $stmt->execute([
            $data['patient_name'],
            $data['patient_age'],
            $formattedBday,
            $data['patient_gender'],
            $data['patient_email'],
            $data['patient_address'],
            $data['patient_condition'],
            $data['patient_contact'],
            $data['patient_id']
        ]);
        
        
        if ($result) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Error occurred while updating the patient.'];
        }
    }

    public function deletePatient($patientId) {
        $stmt = $this->conn->prepare("DELETE FROM add_appointments WHERE id = ?");
        
        if ($stmt->execute([$patientId])) {
            
            echo json_encode(['success' => true]);
        } else {
            
            echo json_encode(['success' => false, 'message' => 'Error occurred while deleting the patient.']);
        }
        exit;
    }
}

if (isset($_POST['btn-reset-password'])) {
    $csrf_token = trim($_POST['csrf_token']);
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

    $admin = new ADMIN();
    $admin->resetPassword($token, $new_password, $csrf_token);
}

if (isset($_POST['btn-admin-addpatient'])) {
    $pName = trim($_POST['patient_name']);
    $pAge = trim($_POST['patient_age']);
    $pBday = trim($_POST['patient_bday']);
    $pGender = trim($_POST['patient_gender']);
    $pEmail = trim($_POST['patient_email']);
    $pAddress = trim($_POST['patient_address']);
    $pCondition = trim($_POST['patient_condition']);
    $pContact = trim($_POST['patient_contact']);

    $admin = new ADMIN();
    $admin->addAppointments($pName, $pAge, $pBday, $pGender, $pEmail, $pAddress, $pCondition, $pContact);
}


if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'update_patient':
            
            $patientId = $_POST['update_id']; 
            $data = [
                'patient_id' => $patientId,
                'patient_name' => $_POST['update_name'],
                'patient_age' => $_POST['update_age'],
                'patient_bday' => $_POST['update_bday'],
                'patient_gender' => $_POST['update_gender'],
                'patient_email' => $_POST['update_email'],
                'patient_address' => $_POST['update_address'],
                'patient_condition' => $_POST['update_condition'],
                'patient_contact' => $_POST['update_contact']
            ];
            
            $admin = new ADMIN();
            $result = $admin->updatePatient($data);
            echo json_encode($result);
            break;
            
        case 'delete_patient':
            $admin = new ADMIN();
            $result = $admin->deletePatient($_POST['patient_id']);
            echo json_encode($result);
            break;

        case 'update_user':
            $data = [
                'user_id' => $_POST['user_id'],
                'fullname' => $_POST['fullname'],
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'verify_status' => $_POST['verify_status']
            ];
            
            $admin = new ADMIN();
            $result = $admin->updateUser($data);
            echo json_encode($result);
            break;

        case 'delete_user':
            $admin = new ADMIN();
            $result = $admin->deleteUser($_POST['user_id']);
            echo json_encode($result);
            break;
    }
}
?>
