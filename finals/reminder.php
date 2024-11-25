<?php
include 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$query = "SELECT appointments.*, patients.contact_info, services.name as service_name 
          FROM appointments 
          JOIN patients ON appointments.patient_id = patients.patient_id 
          JOIN services ON appointments.service_id = services.service_id
          WHERE appointments.date = CURDATE() AND appointments.time <= CURTIME() + INTERVAL 48 HOUR";

$stmt = $conn->prepare($query);
$stmt->execute();


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    var_dump($row);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com';
        $mail->Password = 'your_email_password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        
        if (filter_var($row['contact_info'], FILTER_VALIDATE_EMAIL)) {
            $mail->setFrom('from_email@example.com', 'Dental Practice');
            $mail->addAddress($row['contact_info']);
            
            $mail->isHTML(true);
            $mail->Subject = 'Appointment Reminder';
            $mail->Body = "Dear Patient, <br><br> This is a reminder for your upcoming appointment on {$row['date']} at {$row['time']} for a {$row['service_name']} service. <br><br> Please confirm your attendance. <br><br> Regards, <br> Dental Practice";

            $mail->send();
            echo "Reminder sent to " . $row['contact_info'] . "<br>";
        } else {
            echo "Invalid email address for patient: " . $row['contact_info'] . "<br>";
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}<br>";
    }
}
?>
