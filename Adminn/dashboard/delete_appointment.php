<?php
session_start();
include_once __DIR__. '/../database/dbconnection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    
    $sql = "DELETE FROM appointments WHERE id = $appointment_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Appointment Deleted.'); window.location.href = 'manage_appointments.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    
    header("Location: manage_appointments.php");
    exit();
} else {
    echo "No appointment selected.";
}
?>
