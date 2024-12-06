<?php
$servername = "localhost";
$username = "Admin";  
$password = "123456789";    
$dbname = "dental clinic";  // Change this to your database name

// change na lang connection depend sa ano mo
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
