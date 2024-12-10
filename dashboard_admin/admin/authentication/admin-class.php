<?php 
require_once __DIR__.'/../../../database/dbconnection.php';
require_once __DIR__.'/../../../config/settings-configuration.php';
require_once __DIR__.'/../../../src/vendor/autoload.php';
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
    
    public function adminSignin($username, $password, $csrf_token)
    {
        try {
                if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
                    echo "<script>alert('INVALID CSRF Token.'); window.location.href = '../../../admin.php';</script>";
                    exit;
                }
                unset($_SESSION['csrf_token']);

                $stmt = $this->runQuery("SELECT * FROM admin WHERE username = :username AND password = :password");
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $password
                ]);

                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($admin) {
                    $query = "UPDATE admin SET status = 'active' WHERE id = :id";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute(array(":id" => $admin['id']));
                
                    $_SESSION['adminSession'] = $admin['id'];
                    echo "<script>alert('Welcome {$admin['username']}!'); window.location.href = '../index.php' ;</script>";
                    exit;
                } else {
                    echo "<script>alert('Invalid password. Try again.'); window.location.href = '../../../admin.php' ;</script>";
                    exit;
                }

            } catch(PDOException $ex){
              echo $ex->getMessage();
        }
    }

    public function adminSignout()
    {

       if(isset($_SESSION['adminSession'])){
            try{
                $query = "UPDATE admin SET status = 'not active' WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->execute(array(":id" => $_SESSION['adminSession']));

            } catch(PDOException $ex) {
                echo $ex->getMessage();
            }
       }

       unset($_SESSION['adminSession']);
       echo "<script>alert('You have signed out successfully.'); window.location.href = '../../../admin.php';</script>";
       exit;
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

    public function isUserLoggedIn()
    {
        if(isset($_SESSION['adminSession'])){
            return true;
        }
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
        echo "<script>alert('Invalid CSRF token.'); window.location.href = '../../../reset-password.php?token=$token'; </script>";
        exit;
    }
    unset($_SESSION['csrf_token']);

    $stmt = $this->runQuery("UPDATE admin SET password = :password");
    $stmt->execute([':password' => $new_password]);
    
    echo "<script>alert('Password reset successfully.'); window.location.href = 'index.php' ;</script>";
    exit;
}
}

if(isset($_POST['btn-reset-password'])){
    $csrf_token = trim($_POST['csrf_token']);
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

    $admin = new ADMIN();
    $admin->resetPassword($token, $new_password, $csrf_token);
}

if(isset ($_POST['btn-admin-signin'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $csrf_token = trim($_POST['csrf_token']);

    $admin = new ADMIN();
    $admin->adminSignin($username, $password, $csrf_token);
}

if(isset($_GET['admin-signout']))
{
    $admin = new ADMIN();
    $admin->adminSignout();
}
