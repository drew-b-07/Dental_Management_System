<?php
require_once __DIR__.'../../../database/dbconnection.php';
require_once __DIR__.'../../../config/settings-configuration.php';
require_once __DIR__.'../../../src/vendor/autoload.php';

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
    }

    public function userSignUp()
    {

    }

    public function userSignIn()
    {

    }

    public function userSignOut()
    {

    }

    public function resetPassword()
    {

    }

    public function isUserLoggedIn()
    {

    }

    public function redirect($url)
    {
        header('$url');
    }
}

?>