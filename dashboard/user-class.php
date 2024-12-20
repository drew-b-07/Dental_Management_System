<?php
require_once __DIR__.'/../database/dbconnection.php';
require_once __DIR__.'/../config/settings-configuration.php';
require_once __DIR__.'/../src/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
        $mail->setFrom($smtp_email, "Dental Care Clinic");
        $mail->Subject = $subject;

        $logopath = __DIR__.'/../../src/img/icon.png';
        $mail->addEmbeddedImage($logopath,'logo');

        $mail->msgHTML($message);
        $mail->Send();
    }

    public function userSignUp($fullname, $email, $username, $password, $csrf_token)
    {
        try
        {
            // CSRF token validation
            if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) 
            {
                echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);

            // Generate OTP and prepare session data
            $otp = rand(10000, 999999);
            $_SESSION['user_registration'] = [
                'fullname' => $fullname,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'otp' => $otp
            ];

            $_SESSION['userSession'] = true;
    
        } catch (PDOException $e) {
            echo "<script>alert('An error occurred during sign up. Please try again.'); window.location.href = '../';</script>";
            exit;
        }
    }

    public function userOTP($otp, $email, $fullname, $username, $password, $confirmPassword)
    {
        if($email == NULL){
            echo "<script>alert('No email found.'); window.location.href = '../';</script>";
            exit;
        } else {
            $stmt = $this->runQuery("SELECT * FROM user WHERE email = :email");
            $stmt->execute(array (":email" => $email));
            $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                echo "<script>alert('Email already taken. Please try another one'); window.location.href = '../';</script>";
                exit;
            } else {
                $stmt = $this->runQuery("SELECT * FROM user WHERE username = :username");
                $stmt->execute(array (":username"=> $username));
                $stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    echo "<script>alert('Username is already used.'); window.location.href = '../';</script>";
                    exit;
                } else if (strlen($password) < 6) {
                    echo "<script>alert('Password must be at least 6 characters long.'); window.location.href = '../';</script>";
                    exit;
                } else if ($password !== $confirmPassword){
                    echo "<script>alert('Password does not match.'); window.location.href = '../';</script>";
                    exit;
                }
            }

            // Hash the password
            $hashed_password = md5($password);
    
            try{
            // Insert the new user into the database
            $stmt = $this->runQuery("INSERT INTO user (fullname, email, username, password, user_status, verify_status ) VALUES (:fullname, :email, :username, :password, :user_status, :verify_status)");
            $stmt->execute([
                ':fullname' => $fullname,
                ':email' => $email,
                ':username' => $username,
                ':password' => $hashed_password,
                ':user_status' => 'not_active',
                ':verify_status' => 'verifying'
            ]);

            $_SESSION['userSession'] = true;

            } catch(PDOException $e){
                echo "<script>alert('An error occurred during signup. Please try again.'); window.location.href = '../';</script>";
                exit;
            }

                $_SESSION['OTP'] = $otp;
                $subject = "OTP VERIFICATION";
                $message = "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <title>OTP Verification</title>
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

                        h1{
                            color:#333333;
                            font-size: 24px;
                            margin-bottom: 20px;
                        }

                        p {
                            color: #666666;
                            font-size: 16px;
                            margin-bottom: 10px;
                        }

                        .button {
                            display: inline-block;
                            padding: 12px 24px;
                            background-color: #0088cc;
                            color: #ffffff;
                            text-decoration: none;
                            border-radius: 4px;
                            font-size: 16px;
                            margin-top: 20px;
                        }

                        .logo {
                            display: block;
                            text-align:  center;
                            margin-bottom: 30px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='logo'>
                            <img src='cid:logo' alt='Logo' width='300'>
                        </div>
                        <h1>OTP Verification</h1>
                        <p>Hello, $fullname</p>
                        <p>Your OTP is: $otp</p>
                        <p>If you didn't request an OTP, please ignore this email.</p>
                        <p>Thank you!</p>
                    </div>
                </body>
                </html>";

                $this->send_email($email, $message, $subject, $this->smtp_email, $this->smtp_password);
                echo "<script>alert('We sent the OTP to $email'); window.location.href = '../verify-otp.php';</script>";

                $_SESSION['OTP'] = $otp;
                $_SESSION['not_verify_fullname'] = $fullname;
                $_SESSION['not_verify_email'] = $email;
                $_SESSION['not_verify_username'] = $username;
                $_SESSION['not_verify_password'] = $password;
        }
    }

    public function verifyUser($fullname, $email, $username, $password, $otp, $csrf_token)
    {

        if (!isset($_SESSION['OTP']) || !isset($_SESSION['not_verify_email'])) {
            echo "<script>alert('Invalid Action: Missing session data.'); window.location.href = '../';</script>";
            exit;
        }

        if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../verify-otp.php';</script>";
            exit;
        }

        if ($otp == $_SESSION['OTP']) {
            unset($_SESSION['OTP']);

            $stmt = $this->runQuery("UPDATE user SET verify_status = 'verified' WHERE email = :email");
            $stmt->execute([':email' => $email]);

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
                        <img src='cid:logo' alt='Logo' width='300'>
                    </div>
                    <h1>Welcome</h1>
                    <p>Hello, <strong>$fullname</strong></p>
                    <p>Welcome to Dental Care!</p>
                    <p>If you did not sign up for an account, you can safely ignore this email.</p>
                    <p>Thank you!</p>
                </div>
            </body>
            </html>";

            $this->send_email($email, $message, $subject, $this->smtp_email, $this->smtp_password);
            echo "<script>alert('Verification successful! Thank you for verifying your email.'); window.location.href = '../';</script>";

            unset($_SESSION['not_verify_username']);
            unset($_SESSION['not_verify_email']);
            unset($_SESSION['not_verify_password']);

            $this->userSignUp($fullname, $email, $username, $password, $csrf_token);
            
        } else if ($otp == NULL) {
            echo "<script>alert('No OTP Found.'); window.location.href = '../verify-otp.php';</script>";
            exit;     
        } else {
            echo "<script>alert('It appears that the OTP you entered is invalid.'); window.location.href = '../verify-otp.php';</script>";
            exit;
        }
    }

    public function getUserProfile($userId)
    {
    try {
        $stmt = $this->runQuery("SELECT fullname, email, username FROM user WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return $user;
            } else {
                echo "<script>alert('User not found. Please log in again.'); window.location.href = '../../';</script>";
                exit;
            }
        } catch (PDOException $e) {
            echo "<script>alert('An error occurred while fetching user profile.'); window.location.href = '../../';</script>";
            exit;
        }
    }

    public function userSignIn($username, $password, $csrf_token)
    {
        try {
            if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
                echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);
    
            $hashed_password = md5($password);
    
            $stmt = $this->runQuery("SELECT * FROM user WHERE username = :username AND password = :password");
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashed_password
            ]);
    
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                if ($user['verify_status'] !== 'verified') {
                    echo "<script>alert('Your account is not verified. Please verify your email before signing in.'); window.location.href = '../';</script>";
                    exit;
                }
    
                $query = "UPDATE user SET user_status = 'active' WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->execute(array(":id" => $user['id']));
            
                $_SESSION['userSession'] = $user['id'];
                echo "<script>alert('Welcome {$user['username']}!'); window.location.href = './user/home.php';</script>";
                exit;
            } else {
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
                    echo "<script>alert('Welcome {$admin['username']}!'); window.location.href = './admin/index.php';</script>";
                    exit;
                }
            }
    
            echo "<script>alert('Invalid username or password. Please try again.'); window.location.href = '../';</script>";
            exit;
    
        } catch (PDOException $e) {
            echo "<script>alert('An error occurred during sign in. Please try again.'); window.location.href = '../';</script>";
            exit;
        }
    }

    public function userSignOut()
    {
        try {
            // Check for user session
            if (isset($_SESSION['userSession'])) {
                $query = "UPDATE user SET user_status = 'not_active' WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->execute(array(":id" => $_SESSION['userSession']));
                unset($_SESSION['userSession']);
            }
    
            echo "<script>alert('You have signed out successfully.'); window.location.href = '../';</script>";
            exit;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function adminSignOut()
    {
        try{
            if (isset($_SESSION['adminSession'])) {
                $query = "UPDATE admin SET status = 'not active' WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->execute(array(":id" => $_SESSION['adminSession']));
                unset($_SESSION['adminSession']);
            }
            
            echo "<script>alert('You have signed out successfully.'); window.location.href = '../';</script>";
            exit;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    

    public function forgotPassword($email, $csrf_token) {
        if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            echo "<script>alert('Invalid CSRF token.'); window.location.href = '../' ;</script>";
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
    
            echo "<script>alert('A password reset link has been sent to your email.'); window.location.href = '../';</script>";
        } else {
            echo "<script>alert('No account found with that email address.'); window.location.href = '../';</script>";
        }
    }

    public function resetPassword($token, $new_password, $csrf_token)
    {
        try {
            // Security Purposes via CSRF Token
            if (!isset($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
                echo "<script>alert('Invalid CSRF Token.'); window.location.href = '../reset-password.php';</script>";
                exit;
            }
            unset($_SESSION['csrf_token']);
            

            // It will change the password, gawin mong indicator yung last doon sa hash
            $hashed_password = md5($new_password);
            
            // Change the password via resetpassword.php
            $stmt = $this->runQuery("UPDATE user SET password = :password, reset_token = NULL, token_expiry = NULL WHERE reset_token = :reset_token");
            $stmt->execute([
                ':password' => $hashed_password,
                ':reset_token' => $token
            ]);

            echo "<script>alert('Password reset successful! You can now log in.'); window.location.href = '../';</script>";
            exit;

        } catch (PDOException $e) {
            echo "<script>alert('An error occurred during password reset. Please try again.'); window.location.href = '../reset-password.php';</script>";
            exit;
        }
    }

    public function bookAppointment(){
        
    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['userSession']);
    }

    public function isAdminLoggedIn(){
        return isset($_SESSION['adminSession']);
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
    if(isset($_POST['btn-forgot-password'])){
        $csrf_token = trim($_POST['csrf_token']);
        $email = trim($_POST['email']);

        $user = new USER();
        $user->forgotPassword($email, $csrf_token);
    }

    if(isset($_POST['btn-reset-password'])){
        $csrf_token = trim($_POST['csrf_token']);
        $token = trim($_POST['token']);
        $new_password = trim($_POST['new_password']);
    
        $user = new USER();
        $user->resetPassword($token, $new_password, $csrf_token);
    }

    if (isset($_POST['btn-user-signup'])) 
    {
        $_SESSION['not_verify_username'] = trim($_POST['username']);
        $_SESSION['not_verify_fullname'] = trim($_POST['fullname']);
        $_SESSION['not_verify_email'] = trim($_POST['email']);
        $_SESSION['not_verify_password'] = trim($_POST['password']);
        
        $fullname = trim($_POST['fullname']);
        $username =  trim($_POST['username']);
        $confirm_password = trim($_POST['confirm_password']);
        $password =trim($_POST['password']);
        $email = trim($_POST['email']);
        $otp = rand(100000, 999999);
    
        $user = new USER();
        $user->userOTP($otp, $email, $fullname, $username, $password, $confirm_password);
    }
    
    if (isset($_POST['btn-signin'])) 
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $csrf_token = trim($_POST['csrf_token']);
    
        $user = new USER();
        $user->userSignin($username, $password, $csrf_token);
    }

    if(isset($_GET['user_profile']))
    {
        $user = new USER();
        $user->getUserProfile($userId);
    }
    
    if (isset($_GET['user_signout'])) 
    {
        $user = new USER();
        $user->userSignout();
    }

    if (isset($_GET['admin_signout'])) 
    {
        $user = new USER();
        $user->adminSignOut();
    }

    if (isset($_POST['btn-verify-user']))
    {
        $username =  $_SESSION['not_verify_username'];
        $fullname = $_SESSION['not_verify_fullname'];
        $email = $_SESSION['not_verify_email'];
        $password = $_SESSION['not_verify_password'];
        $csrf_token = trim($_POST['csrf_token']);
    
       $tokencode = md5(uniqid(rand()));
       $otp = trim($_POST['otp']);
    
       $userVerify = new USER();
       $userVerify->verifyUser($fullname, $email, $username, $password, $otp, $csrf_token);
    }

    if (isset($_POST['btn-book-appointment']))
    {
        $user = new USER();
        $user->bookAppointment();
    }
?>