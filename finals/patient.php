<?php
include 'db_connection.php';

$name = $_POST['name'];
$dob = $_POST['dob'];
$contact_info = $_POST['contact_info'];

$query = "INSERT INTO patients (name, dob, contact_info) 
          VALUES (:name, :dob, :contact_info)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':dob', $dob);
$stmt->bindParam(':contact_info', $contact_info);

if ($stmt->execute()) {
    echo "Patient profile created successfully!";
} else {
    echo "Error creating patient profile.";
}
?>
