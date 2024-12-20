<?php 
require_once __DIR__.'/../database/dbconnection.php';
require_once __DIR__.'/../config/settings-configuration.php';

class MAIN
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->dbConnection();
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    
    public function addAppointment($fullname, $age, $birthday, $phone_number, $address, $pref_appointment, $additional_info)
    {
        try {
            $stmt = $this->runQuery("INSERT INTO patients 
                (fullname, age, birthday, phone_number, address, pref_appointment, additional_info, status) 
                VALUES (:fullname, :age, :birthday, :phone_number, :address, :pref_appointment, :additional_info, 'pending')");
            
            $stmt->execute([
                ':fullname' => $fullname,
                ':age' => $age,
                ':birthday' => $birthday,
                ':phone_number' => $phone_number,
                ':address' => $address,
                ':pref_appointment' => $pref_appointment,
                ':additional_info' => $additional_info
            ]);
            
            echo "<script>alert('Appointment booked.'); window.location.href = './appointment.php' ;</script>";
            exit;

        } catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getPatients() {
        try {
            $stmt = $this->runQuery("SELECT * FROM patients WHERE status != 'processed'");
            $stmt->execute();
            $pendingPatients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $totalpendingPatients = count($pendingPatients);
            
            return ['pendingPatients' => $pendingPatients, 'total' => $totalpendingPatients];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return ['pendingPatients' => [], 'total' => 0];
        }
    }


    
    public function acceptAppointment($id)
    {
        try {
            
            $stmt = $this->runQuery("SELECT * FROM patients WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($patient) {
                
                $insertStmt = $this->runQuery("INSERT INTO appointments 
                    (patient_id, fullname, phone_number, pref_appointment, additional_info, status)
                    VALUES (:patient_id, :fullname, :phone_number, :appointment, :info, 'accepted')");
                $insertStmt->execute([
                    ':patient_id' => $id,
                    ':fullname' => $patient['fullname'],
                    ':phone_number' => $patient['phone_number'],
                    ':appointment' => $patient['pref_appointment'],
                    ':info' => $patient['additional_info']
                ]);
    
                
                $updateStmt = $this->runQuery("UPDATE patients SET status = 'accepted' WHERE id = :id");
                $updateStmt->execute([':id' => $id]);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    

    
    public function denyAppointment($id)
    {
        try {
            $stmt = $this->runQuery("UPDATE patients SET status = 'denied' WHERE id = :id");
            $stmt->execute([':id' => $id]);
        } catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function updateStatus($id, $status) {
        try {
            
            $stmt = $this->runQuery("SELECT * FROM patients WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($patient) {
                if ($status === 'accepted') {
                    
                    $insertStmt = $this->runQuery("INSERT INTO appointments 
                        (patient_id, fullname, phone_number, pref_appointment, additional_info, status)
                        VALUES (:patient_id, :fullname, :phone_number, :appointment, :info, 'accepted')");
                    $insertStmt->execute([
                        ':patient_id' => $id,
                        ':fullname' => $patient['fullname'],
                        ':phone_number' => $patient['phone_number'],
                        ':appointment' => $patient['pref_appointment'],
                        ':info' => $patient['additional_info']
                    ]);
                }
    
                
                $logStmt = $this->runQuery("INSERT INTO appointment_logs 
                    (patient_id, fullname, age, birthday, phone_number, address, pref_appointment, additional_info, status)
                    VALUES (:patient_id, :fullname, :age, :birthday, :phone_number, :address, :pref_appointment, :additional_info, :status)");
                $logStmt->execute([
                    ':patient_id' => $id,
                    ':fullname' => $patient['fullname'],
                    ':age' => $patient['age'],
                    ':birthday' => $patient['birthday'],
                    ':phone_number' => $patient['phone_number'],
                    ':address' => $patient['address'],
                    ':pref_appointment' => $patient['pref_appointment'],
                    ':additional_info' => $patient['additional_info'],
                    ':status' => $status
                ]);
    
                
                $updateStmt = $this->runQuery("UPDATE patients SET status = 'processed' WHERE id = :id");
                $updateStmt->execute([':id' => $id]);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    
    public function getAppointmentLogs() {
        try {
            $stmt = $this->runQuery("SELECT * FROM appointment_logs ORDER BY log_timestamp DESC");
            $stmt->execute();
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $totalLogs = count($logs);
            
            return ['logs' => $logs, 'total' => $totalLogs];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return ['logs' => [], 'total' => 0];
        }
    }

    public function getAcceptedAppointments() {
        try {
            $stmt = $this->runQuery("SELECT fullname, pref_appointment FROM appointments WHERE status = 'accepted'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

    public function getAppoinments() {
        try {
            $stmt = $this->runQuery("SELECT fullname, pref_appointment FROM appointments WHERE status = 'accepted'");
            $stmt->execute();
            $acceptedAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $totalAcceptedAppointments = count($acceptedAppointments);
            
            return ['acceptedAppointments' => $acceptedAppointments, 'total' => $totalAcceptedAppointments];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return ['acceptedAppointments' => [], 'total' => 0];
        }
    }

    public function getPendingAppointments() {
        try {
            $stmt = $this->runQuery("SELECT * FROM patients WHERE status != 'processed'");
            $stmt->execute();
            $pendingAppointment = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $totalpendingAppointment = count($pendingAppointment);
            
            return ['pendingAppointments' => $pendingAppointment, 'total' => $totalpendingAppointment];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return ['pendingAppointments' => [], 'total' => 0];
        }
    } 
    
    public function markAppointmentAsCompleted($id) {
        try {
            
            $stmt = $this->runQuery("SELECT * FROM appointments WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($appointment) {
                
                $insertStmt = $this->runQuery("INSERT INTO completed_appointments 
                    (patient_id, fullname, phone_number, pref_appointment, additional_info, status)
                    VALUES (:patient_id, :fullname, :phone_number, :appointment, :info, 'completed')");
                $insertStmt->execute([
                    ':patient_id' => $appointment['patient_id'],
                    ':fullname' => $appointment['fullname'],
                    ':phone_number' => $appointment['phone_number'],
                    ':appointment' => $appointment['pref_appointment'],
                    ':info' => $appointment['additional_info']
                ]);
    
                
                $deleteStmt = $this->runQuery("DELETE FROM appointments WHERE id = :id");
                $deleteStmt->execute([':id' => $id]);
    
                return true;
            }
            return false;
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            return false;
        }
    }
    
    
}


if (isset($_POST['btn-admin-addpatient'])) {
    $fullname = trim($_POST['fullname']);
    $age = trim($_POST['age']);
    $birthday = trim($_POST['birthday']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $pref_appointment = trim($_POST['pref_appointment']);
    $additional_info = trim($_POST['additional_info']);
    
    $admin = new MAIN();
    $admin->addAppointment($fullname, $age, $birthday, $phone_number, $address, $pref_appointment, $additional_info);
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    $main = new MAIN();

    if ($action == 'accept') {
        $main->updateStatus($id, 'accepted');
    } elseif ($action == 'deny') {
        $main->updateStatus($id, 'denied');
    }

    
    echo "<script>window.location.href = './admin/index.php';</script>";
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'fetchAcceptedAppointments') {
    header('Content-Type: application/json');
    echo json_encode($this->getAcceptedAppointments());
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'markdone') {
    $id = $_POST['id'];
    $main = new MAIN();

    if ($main->markAppointmentAsCompleted($id)) {
        echo json_encode(['success' => true, 'message' => 'Appointment marked as completed.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to mark the appointment as completed.']);
    }
    exit;
}

?>
