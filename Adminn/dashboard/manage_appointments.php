<?php
session_start();
include_once __DIR__. '/../database/dbconnection.php'; 

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


$admin_db = new mysqli("localhost", "Admin", "123456789", "dental clinic"); 


if ($admin_db->connect_error) {
    die("Connection failed: " . $admin_db->connect_error);
}

// Query to fetch appointment details including patient infos
$sql = "SELECT appointments.id, 
               CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name, 
               appointments.appointment_date, 
               appointments.status, 
               appointments.phone, 
               appointments.message
        FROM appointments
        JOIN patients ON appointments.user_id = patients.user_id";

$result = $admin_db->query($sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
</head>
<body>
    <h1>Manage Appointments</h1>
    <a href="add_appointment.php">Add New Appointment</a>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Patient Name</th>
            <th>Phone</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($appointment = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $appointment['id']; ?></td>
                    <td><?php echo $appointment['patient_name']; ?></td>
                    <td><?php echo $appointment['phone']; ?></td>
                    <td><?php echo $appointment['appointment_date']; ?></td>
                    <td>
                        
                        <form action="update_status.php" method="POST">
                            <select name="status">
                                <option value="Pending" <?php echo ($appointment['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Confirmed" <?php echo ($appointment['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="Completed" <?php echo ($appointment['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            </select>
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>" />
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td><?php echo $appointment['message']; ?></td>
                    <td>
                       
                        <a href="edit_appointment.php?id=<?php echo $appointment['id']; ?>">Edit</a> |
                        <a href="delete_appointment.php?id=<?php echo $appointment['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No appointments found.</td></tr>
        <?php endif; ?>
    </table>

    <?php $admin_db->close(); ?>
</body>
</html>
