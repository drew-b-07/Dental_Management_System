<?php
session_start();
include_once __DIR__. '/../database/dbconnection.php';


if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $sql = "INSERT INTO patients (name, age, gender, contact, email) VALUES ('$name', '$age', '$gender', '$contact', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New patient added successfully.'); window.location.href = 'manage_patients.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
</head>
<body>
    <h1>Add New Patient</h1>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" name="age" required>
        <br>
        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <br>
        <label for="contact">Contact:</label>
        <input type="text" name="contact" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <button type="submit">Add Patient</button>
    </form>
</body>
</html>
