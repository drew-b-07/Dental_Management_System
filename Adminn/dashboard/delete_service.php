<?php
session_start();
include_once __DIR__ . '/../database/dbconnection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    $sql = "DELETE FROM services WHERE id = $service_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Service deleted successfully'); window.location.href = 'services.php';</script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: services.php");
    exit();
}
?>
