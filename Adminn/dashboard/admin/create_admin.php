<?php
include_once __DIR__ . '/../../database/dbconnection.php';

//this for admin 

$username = 'Admin';
$password = '123456789';  // Plaintext password lang lalagay

// then automatically na siyang mag hash sa database
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Admin user created successfully.'); window.location.href = 'admin_login.php';</script>";

} else {
    echo "Error: " . $conn->error;
}
?>
