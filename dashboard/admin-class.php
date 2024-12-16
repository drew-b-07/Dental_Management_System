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

    function send_email($email, $message, $subject, $smtp_email, $smtp_password){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host ="smtp.gmail.com";
        $mail->Port = 587;
        $mail->addAddress($email);
        $mail->Username = $smtp_email;
        $mail->Password = $smtp_password;
        $mail->setFrom($smtp_email, "Joanna");
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->Send();
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
 

public function resetPassword($token, $new_password, $csrf_token){
    
        if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            echo "<script>alert('Invalid CSRF token.'); window.location.href = '../reset-password.php?token=$token'; </script>";
            exit;
        }
        unset($_SESSION['csrf_token']);

        $stmt = $this->runQuery("UPDATE admin SET password = :password");
        $stmt->execute([':password' => $new_password]);
        
        echo "<script>alert('Password reset successfully.'); window.location.href = '../' ;</script>";
        exit;
    }

    public function addAppointments($pName, $pAge, $pBday, $pGender, $pEmail, $pAddress, $pCondition, $pContact){
        try{
            $stmt = $this->runQuery("INSERT INTO add_appointments 
            (patient_name, patient_age, patient_bday, patient_gender, patient_email, patient_address, patient_condition, patient_contact) 
            VALUES (:patient_name, :patient_age, :patient_bday, :patient_gender, :patient_email, :patient_address, :patient_condition, :patient_contact)");
            if($stmt->execute([
            ':patient_name' => $pName,
            ':patient_age' => $pAge,
            ':patient_bday' => $pBday,
            ':patient_gender' => $pGender,
            ':patient_email' => $pEmail,
            ':patient_address' => $pAddress,
            ':patient_condition' => $pCondition,
            ':patient_contact' => $pContact
            ]));

            echo 'Record Inserted Successfully!';
            header('Location: ./admin/index.php');
            exit;

            // echo "<script>                 
            // document.addEventListener('DOMContentLoaded', function() {
            //         const toast = document.createElement('div');
            //         toast.textContent = 'Record Inserted Successfully!';
            //         toast.style.position = 'fixed';
            //         toast.style.bottom = '20px';
            //         toast.style.right = '20px';
            //         toast.style.background = '#4caf50';
            //         toast.style.color = '#fff';
            //         toast.style.padding = '10px 15px';
            //         toast.style.borderRadius = '5px';
            //         toast.style.boxShadow = '0px 2px 6px rgba(0, 0, 0, 0.2)';
            //         document.body.appendChild(toast);
            //         setTimeout(() => toast.remove(), 3000);
            // });
            // window.location.href = '../index.php?section=patients' </script>";
            // exit;
                
        } catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
}

if(isset($_POST['btn-reset-password'])){
    $csrf_token = trim($_POST['csrf_token']);
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

    $admin = new ADMIN();
    $admin->resetPassword($token, $new_password, $csrf_token);
}

if(isset($_POST['btn-admin-addpatient'])){
    $pName = trim($_POST['patient_name']);
    $pAge = trim($_POST['patient_age']);
    $pBday = trim($_POST['patient_bday']);
    $pGender = trim($_POST['patient_gender']);
    $pEmail = trim($_POST['patient_email']);
    $pAddress= trim($_POST['patient_address']);
    $pCondition = trim($_POST['patient_condition']);
    $pContact = trim($_POST['patient_contactno']);

    $admin = new ADMIN();
    $admin->addAppointments($pName, $pAge, $pBday, $pGender, $pEmail, $pAddress, $pCondition, $pContact);
}