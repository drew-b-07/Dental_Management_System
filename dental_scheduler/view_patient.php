<?php

require_once 'Database.php';

$database = new Database();
$conn = $database->getConnection();

$patient_id = 1; // example patient ID

try {
    $query = "SELECT * FROM patients WHERE patient_id = :patient_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    
    $patient = $stmt->fetch();
    
    if ($patient) {
        echo "Patient Name: " . $patient['first_name'] . " " . $patient['last_name'] . "<br>";
        echo "Medical History: " . $patient['medical_history'] . "<br>";
        echo "Dental History: " . $patient['dental_history'] . "<br>";
    } else {
        echo "Patient not found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
