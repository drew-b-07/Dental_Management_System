<?php
session_start();
include_once __DIR__ . '/../../database/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin'] = $username;
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password.'); window.location.href = 'admin_login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found'); window.location.href = 'admin_login.php';</script>"; // they're not like dun sa code ni sir 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../../src/style.css"> <!--- yung style css is hindi magkatugma -->
</head>
<body>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required> <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required> <br>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
