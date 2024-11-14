<?php
// schedule_reminder.php

require_once 'Database.php';

$database = new Database();
$conn = $database->getConnection();

$appointment_id = 1; // example appointment ID
$reminder_time = "2024-11-29 10:00:00"; // 48 hours before appointment
$reminder_type = 'Email';

try {
    $query = "INSERT INTO reminders (appointment_id, reminder_time, reminder_type) 
              VALUES (:appointment_id, :reminder_time, :reminder_type)";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->bindParam(':reminder_time', $reminder_time);
    $stmt->bindParam(':reminder_type', $reminder_type);

    if ($stmt->execute()) {
        echo "Reminder scheduled successfully.";
    } else {
        echo "Error scheduling reminder.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
