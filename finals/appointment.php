<?php
include 'db_connection.php';

$patient_id = $_POST['patient_id'];
$dentist_id = $_POST['dentist_id'];
$service_id = $_POST['service_id'];
$date = $_POST['date'];
$time = $_POST['time'];

$query = "SELECT * FROM appointments WHERE dentist_id = :dentist_id AND date = :date AND time = :time";
$stmt = $conn->prepare($query);
$stmt->bindParam(':dentist_id', $dentist_id);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':time', $time);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Sorry, the appointment slot is already taken. Please choose another time.";
} else {
    
    $insert_query = "INSERT INTO appointments (patient_id, dentist_id, service_id, date, time, status) 
                     VALUES (:patient_id, :dentist_id, :service_id, :date, :time, 'Scheduled')";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bindParam(':patient_id', $patient_id);
    $insert_stmt->bindParam(':dentist_id', $dentist_id);
    $insert_stmt->bindParam(':service_id', $service_id);
    $insert_stmt->bindParam(':date', $date);
    $insert_stmt->bindParam(':time', $time);

    if ($insert_stmt->execute()) {
        echo "Appointment successfully booked!";
    } else {
        echo "Error booking appointment.";
    }
}
?>
