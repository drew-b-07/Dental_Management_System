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

    $sql = "SELECT * FROM patients WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "<script>alert('Patient not found!'); window.location.href = 'manage_patients.php';</script>";
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_initial'];
    $age = $_POST['age'];
    $schedule = $_POST['schedule'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];

    
    $update_sql = "UPDATE patients SET last_name = ?, first_name = ?, middle_initial = ?, age = ?, schedule = ?, birthday = ?, address = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_sql);

   
    $stmt->bind_param("sssisssi", $last_name, $first_name, $middle_initial, $age, $schedule, $birthday, $address, $patient_id);

    if ($stmt->execute()) {
        echo "Patient details updated successfully!";
        header("Location: manage_patients.php"); 
        exit();
    } else {
        echo "<script>alert('Error updating patient details!'); window.location.href = 'manage_patients.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
</head>
<body>
    <h1>Edit Patient</h1>
    <form method="POST">
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" value="<?php echo $patient['last_name']; ?>" required><br><br>

        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" value="<?php echo $patient['first_name']; ?>" required><br><br>

        <label for="middle_initial">Middle Initial:</label><br>
        <input type="text" id="middle_initial" name="middle_initial" value="<?php echo $patient['middle_initial']; ?>" required><br><br>

        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" value="<?php echo $patient['age']; ?>" required><br><br>

        <label for="schedule">Schedule:</label><br>
        <input type="text" id="schedule" name="schedule" value="<?php echo $patient['schedule']; ?>" required><br><br>

        <label for="birthday">Birthday:</label><br>
        <input type="date" id="birthday" name="birthday" value="<?php echo $patient['birthday']; ?>" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo $patient['address']; ?>" required><br><br>

        <button type="submit">Update Patient</button>
    </form>
</body>
</html>
