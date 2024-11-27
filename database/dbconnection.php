<?php 

class Database 
{ 
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct()
    {
        if($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '192.168.1.72'){
            $this->host = "localhost";
            $this->db_name = "otp";
            $this->username = "root";
            $this->password = "";
        }
        else{
            $this->host = "localhost";
            $this->db_name = "";
            $this->username = "";
            $this->password = "";
        }
    }

    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
            $this->activateUsers(':email');
            $this->activateAdmin(':username');

        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    private function activateUsers($email)
    {
        $query = "UPDATE user SET status = 'active' WHERE email = :email AND status = 'not active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array(":email" => $email));
    }

    private function activateAdmin($username)
    {
        $query = "UPDATE admin SET status = 'active' WHERE username = :username AND status = 'not active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array(":username" => $username));
    }
}
?>