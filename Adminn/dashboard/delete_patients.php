<?php
session_start();
include_once __DIR__ . '/../database/dbconnection.php'; 

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    // Delete patient record sa database
    $sql = "DELETE FROM patients WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id); //bind param is the parameter "i" is integer ganon "s" is string

    if ($stmt->execute()) {
        echo "Patient deleted successfully!";
        header("Location: manage_patients.php"); 
        exit();
    } else {
        echo "<script>alert('Error deleting patient!'); window.location.href = 'manage_patients.php';</script>";
    }
} else {
    echo "<script>alert('No Patient ID provided!'); window.location.href = 'manage_appointments.php';</script>";
}
?>
