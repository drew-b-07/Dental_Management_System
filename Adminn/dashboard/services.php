<?php
session_start();
include_once __DIR__ . '/../database/dbconnection.php';

// Check if user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Dental Services</h1>
    <a href="add_service.php">Add New Service</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tooth Number</th>
                <th>Service</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['tooth_number']; ?></td>
                    <td><?php echo $row['service_name']; ?></td>
                    <td><?php echo "PHP " . number_format($row['price'], 2); ?></td>
                    <td>
                        <a href="edit_service.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_service.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br><a href="dashboard.php">Back to Admin Dashboard</a>
</body>
</html>
