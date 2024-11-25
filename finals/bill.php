<?php
include 'db_connection.php';


$patient_id = $_POST['patient_id'];
$appointment_id = $_POST['appointment_id'];
$amount_due = $_POST['amount_due'];
$amount_paid = $_POST['amount_paid'];
$status = $_POST['status']; 


$query = "INSERT INTO billing (patient_id, appointment_id, amount_due, amount_paid, status) 
          VALUES (:patient_id, :appointment_id, :amount_due, :amount_paid, :status)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':patient_id', $patient_id);
$stmt->bindParam(':appointment_id', $appointment_id);
$stmt->bindParam(':amount_due', $amount_due);
$stmt->bindParam(':amount_paid', $amount_paid);
$stmt->bindParam(':status', $status);

if ($stmt->execute()) {
    echo "Billing details added successfully!";
} else {
    echo "Error adding billing details.";
}
?>
