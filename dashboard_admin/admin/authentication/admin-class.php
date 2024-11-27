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
                echo "<script>alert('INVALID CSRF Token.'); window.location.href = '../../../';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);

            $query = "UPDATE admin SET status = 'active' WHERE username = :username AND status = 'not active'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(array(":username" => $username));

            }catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function adminSignout()
    {
       unset($_SESSION['adminSession']);
       echo "<script>alert('Admin Sign Out Successfully'); window.location.href = '../../../';</script>";
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

   public function forgotPassword($email, $csrf_token) {
    if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo "<script>alert('Invalid CSRF token.'); window.location.href = '../../../forgot-password.php';</script>";
        exit;
    }
    unset($_SESSION['csrf_token']);
    
    // Check if the email exists
    $stmt = $this->runQuery("SELECT * FROM user WHERE email = :email");
    $stmt->execute(array(":email" => $email));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1 && isset($userRow['id'])) { // Check that user exists
        $user_id = $userRow['id'];

        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $tokenExpiry = date("Y-m-d H:i:s", strtotime('+30 seconds'));

        // Update the user's token in the database
        $updateStmt = $this->runQuery("UPDATE user SET reset_token = :reset_token, token_expiry = :token_expiry WHERE email = :email");
        $updateStmt->execute(array(
            ":reset_token" => $token,
            ":token_expiry" => $tokenExpiry,
            ":email" => $email
        ));

        $resetLink = "http://localhost/Finals-Dental-Clinic/reset-password.php?id=$user_id&tokencode=$token";
        
        $subject = "Password Reset Request";
        $message = "<html><body><p>Password reset link: <a href='$resetLink'>Reset Password</a></p></body></html>";

        $this->send_email($email, $message, $subject, $this->smtp_email, $this->smtp_password);

        echo "<script>alert('A password reset link has been sent to your email.'); window.location.href = '../../../index.php';</script>";
    } else {
        echo "<script>alert('No account found with that email address.'); window.location.href = '../../../forgot-password.php';</script>";
    }
}

    
    

public function resetPassword($token, $new_password, $csrf_token){
    
    if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        echo "<script>alert('Invalid CSRF token.'); window.location.href = '../../../reset-password.php?token=$token'; </script>";
        exit;
    }
    unset($_SESSION['csrf_token']);


    // Retrieve user with the provided token
    $stmt = $this->runQuery("SELECT * FROM user WHERE reset_token = :reset_token AND token_expiry >= :current_time");
    $stmt->execute(array(
        ":reset_token" => $token,
        ":current_time" => date("Y-m-d H:i:s")
    ));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1) {
        $hash_password = md5($new_password);
        $updateStmt = $this->runQuery("UPDATE user SET password = :password, reset_token = NULL, token_expiry = NULL WHERE reset_token = :reset_token");
        $updateStmt->execute(array(
            ":password" => $hash_password,
            ":reset_token" => $token
        ));

        echo "<script>alert('Your password has been successfully reset. You can now log in with your new password.'); window.location.href = '../../../index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid or expired token. Please request a new password reset.'); window.location.href = '../../../forgot-password.php';</script>";
        exit;
    }
}
    
}

if(isset($_POST['btn-forgot-password'])){
    $csrf_token = trim($_POST['csrf_token']);
    $email = trim($_POST['email']);

    $adminForgot = new ADMIN();
    $adminForgot->forgotPassword($email, $csrf_token);
}

if(isset($_POST['btn-reset-password'])){
    $csrf_token = trim($_POST['csrf_token']);
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

    $adminReset = new ADMIN();
    $adminReset->resetPassword($token, $new_password, $csrf_token);
}

if(isset ($_POST['btn-admin-signin'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $csrf_token = trim($_POST['csrf_token']);

    $adminSignin = new ADMIN();
    $adminSignin->adminSignin($email, $password, $csrf_token);
}

if(isset($_GET['admin_signout']))
{
    $adminSignout = new ADMIN();
    $adminSignout->adminSignout();
}
?>