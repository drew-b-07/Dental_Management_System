<?php
// schedule_appointment.php

require_once 'Database.php';

$database = new Database();
$conn = $database->getConnection();

// Sample data for a new appointment
$patient_id = 1; // example patient ID
$dentist_id = 2; // example dentist ID
$appointment_date = "2024-12-01 10:00:00";
$treatment_type = "Consultation";

try {
    $query = "INSERT INTO appointments (patient_id, dentist_id, appointment_date, treatment_type) 
              VALUES (:patient_id, :dentist_id, :appointment_date, :treatment_type)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->bindParam(':dentist_id', $dentist_id);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':treatment_type', $treatment_type);

    if ($stmt->execute()) {
        echo "Appointment scheduled successfully.";
    } else {
        echo "Error scheduling appointment.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
