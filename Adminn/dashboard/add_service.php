<?php
session_start();
include_once __DIR__ . '/../database/dbconnection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tooth_number = $_POST['tooth_number'];
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];

    // Allow the tooth_number to be a string (example lang "Whole Teeth" for dental check up)
    $sql = "INSERT INTO services (tooth_number, service_name, price) VALUES ('$tooth_number', '$service_name', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New service added successfully'); window.location.href = 'services.php';</script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>
</head>
<body>
    <h1>Add New Service</h1>
    <form method="POST" action="">
        <label for="tooth_number">Tooth Number (e.g., "Whole Teeth" for Check-up or number):</label><br>
        <input type="text" name="tooth_number" required><br><br>

        <label for="service_name">Service Name:</label><br>
        <input type="text" name="service_name" required><br><br>

        <label for="price">Price:</label><br>
        <input type="number" name="price" step="0.01" required><br><br>

        <button type="submit">Add Service</button>
    </form>
    <br><a href="services.php">Back to Services List</a>
</body>
</html>
