<?php
session_start();
include_once __DIR__ . '/../database/dbconnection.php'; 

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


$sql = "SELECT * FROM patients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>
</head>
<body>
    <h1>Manage Patients</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Initial</th>
            <th>Age</th>
            <th>Schedule</th>
            <th>Birthday</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php 
        // Loop through all patients and display them in the table
        while ($patient = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $patient['user_id']; ?></td>
            <td><?php echo $patient['last_name']; ?></td> 
            <td><?php echo $patient['first_name']; ?></td> 
            <td><?php echo $patient['middle_initial']; ?></td> 
            <td><?php echo $patient['age']; ?></td>
            <td><?php echo $patient['schedule']; ?></td>
            <td><?php echo $patient['birthday']; ?></td>
            <td><?php echo $patient['address']; ?></td>
            <td>
                <a href="edit_patients.php?id=<?php echo $patient['user_id']; ?>">Edit</a> |
                <a href="delete_patients.php?id=<?php echo $patient['user_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
