<?php
session_start();
include_once __DIR__. '/../database/dbconnection.php';


if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


$patients_result = $conn->query("SELECT id, name FROM patients");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];

    
    $sql = "INSERT INTO appointments (patient_id, appointment_date, status) 
            VALUES ('$patient_id', '$appointment_date', 'Pending')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New appointment added successfully.'); window.location.href = 'manage_appointments.php';</script>";
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment</title>
</head>
<body>
    <h1>Add New Appointment</h1>
    <form method="POST" action="">
        <label for="patient_id">Patient:</label>
        <select name="patient_id" required>
            <?php while($patient = $patients_result->fetch_assoc()): ?>
                <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <br>

        <label for="appointment_date">Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" required>
        <br>

        <button type="submit">Add Appointment</button>
    </form>
</body>
</html>
