<?php
require_once __DIR__.'/../../../database/dbconnection.php';
require_once __DIR__.'/../../../config/settings-configuration.php';
require_once __DIR__.'/../../../src/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class USER{
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

    public function verifyUser($username, $email, $password, $tokencode, $otp, $csrf_token)
    {
        if ($otp == $_SESSION['OTP']) {
            unset($_SESSION['OTP']);

            $subject = "VERIFICATION SUCCESS";
            $message = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Verification Success</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color:#f5f5f5;
                        margin: 0;
                        padding: 0;
                    }
    
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 30px;
                        background-color: #ffffff;
                        border-radius: 4px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    }
    
                    h1 {
                        color:#333333;
                        font-size: 24px;
                        margin-bottom: 20px;
                    }
    
                    p {
                        color: #666666;
                        font-size: 16px;
                        margin-bottom: 10px;
                    }
    
                    .logo {
                        display: block;
                        text-align: center;
                        margin-bottom: 30px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='logo'>
                        <img src='cid:logo' alt='Logo' width='150'>
                    </div>
                    <h1>Welcome</h1>
                    <p>Hello, <strong>$username</strong></p>
                    <p>Welcome to Dental Care!</p>
                    <p>If you did not sign up for an account, you can safely ignore this email.</p>
                    <p>Thank you!</p>
                </div>
            </body>
            </html>";

            $this->send_email($email, $message, $subject, $this->smtp_email, $this->smtp_password);
            echo "<script>alert('Verification successful! Thank you for verifying your email.'); window.location.href = '../../../';</script>";

            unset($_SESSION['not_verify_username']);
            unset($_SESSION['not_verify_email']);
            unset($_SESSION['not_verify_password']);

            $this->userSignUp($username, $email, $password, $csrf_token);
            
        } else if ($otp == NULL) {
            echo "<script>alert('No OTP Found'); window.location.href = '../../../verify-otp.php';</script>";
            exit;
        } else {
            echo "<script>alert('It appears that the OTP you entered is invalid'); window.location.href = '../../../verify-otp.php';</script>";
            exit;
        }
    }

    public function userSignUp($username, $email, $password, $csrf_token)
    {
        try
        {
            if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) 
            {
                echo "<script>alert('INVALID CSRF Token.'); window.location.href = '../../../index.php';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);

            //Ichecheck nito kung yung email is registered na
            $stmt = $this->runQuery("SELECT * FROM user WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            if ($stmt->rowCount() > 0) 
            {
                echo "<script>alert('Email is already registered.'); window.location.href = '../../../index.php';</script>";
                exit;
            }

            $hashed_password = md5($password);

            // Insert the new user into the database
            $stmt = $this->runQuery("INSERT INTO user (username, email, password, status) VALUES (:username, :email, :password, :status)");
            $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashed_password,
            ':status' => 'active'
            ]);

            echo "<script>alert('Sign up successful! You can now log in.'); window.location.href = '../../../index.php';</script>";
            exit;


        } catch (PDOException $e)
        {
            echo "<script>alert('An error occurred during sign up. Please try again.'); window.location.href = '../../../index.php';</script>";
            exit;
        }
    }

    public function userSignIn($email, $password, $csrf_token)
    {
        try {
            // Verify CSRF Token
            if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
                echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../../../login.php';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);

            // Hash the input password
            $hashed_password = md5($password);

            // Check if the user exists and the status is active
            $stmt = $this->runQuery("SELECT * FROM user WHERE email = :email AND password = :password AND status = :status");
            $stmt->execute([
                ':email' => $email,
                ':password' => $hashed_password,
                ':status' => 'active'
            ]);

            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['userSession'] = $user['id'];

                echo "<script>alert('Welcome User: {$user['username']}!'); window.location.href = '../home.php';</script>";
                exit;
            } else {
                echo "<script>alert('Invalid email or password. Please try again.'); window.location.href = '../../../index.php';</script>";
                exit;
            }

        } catch (PDOException $e) {
            echo "<script>alert('An error occurred during sign in. Please try again.'); window.location.href = '../../../login.php';</script>";
            exit;
        }
    }

    public function userSignOut()
    {
        unset($_SESSION['userSession']);
        echo "<script>alert('You have signed out successfully.'); window.location.href = '../../../index.php';</script>";
        exit;
    }

    public function resetPassword($email, $new_password, $csrf_token)
    {
        try {
            // Security Purposes via CSRF Token
            if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
                echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../../../reset-password.php';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);

            // It will change the password, gawin mong indicator yung last doon sa hash
            $hashed_password = md5($new_password);

            // Change the password via resetpassword.php
            $stmt = $this->runQuery("UPDATE user SET password = :password WHERE email = :email");
            $stmt->execute([
                ':password' => $hashed_password,
                ':email' => $email
            ]);

            echo "<script>alert('Password reset successful! You can now log in.'); window.location.href = '../../../index.php';</script>";
            exit;

        } catch (PDOException $e) {
            echo "<script>alert('An error occurred during password reset. Please try again.'); window.location.href = '../../../reset-password.php';</script>";
            exit;
        }
    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['userSession']);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function runQuery($sql)
    {
        return $this->conn->prepare($sql);
    }
}

//Handling variables
    if (isset($_POST['btn-user-signup'])) 
    {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $csrf_token = trim($_POST['csrf_token']);
    
        $user = new USER();
        $user->userSignup($username, $email, $password, $csrf_token);
    }
    
    if (isset($_POST['btn-user-signin'])) 
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $csrf_token = trim($_POST['csrf_token']);
    
        $user = new USER();
        $user->userSignin($email, $password, $csrf_token);
    }
    
    if (isset($_GET['user_signout'])) 
    {
        $user = new USER();
        $user->userSignout();
    }

    if (isset($_POST['btn-verify-user']))
    {
        $username =  $_SESSION['not_verify_username'];
        $email = $_SESSION['not_verify_email'];
        $password = $_SESSION['not_verify_password'];
        $csrf_token = trim($_POST['csrf_token']);
    
       $tokencode = md5(uniqid(rand()));
       $otp = trim($_POST['otp']);
    
       $userVerify = new USER();
       $userVerify->verifyUser($username, $email, $password, $tokencode, $otp, $csrf_token);
    }
?>