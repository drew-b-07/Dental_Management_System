<?php
session_start();
include_once __DIR__ . '/../database/dbconnection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    $sql = "SELECT * FROM services WHERE id = $service_id";
    $result = $conn->query($sql);
    $service = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tooth_number = $_POST['tooth_number'];
        $service_name = $_POST['service_name'];
        $price = $_POST['price'];

        $update_sql = "UPDATE services SET tooth_number = '$tooth_number', service_name = '$service_name', price = '$price' WHERE id = $service_id";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Service updated successfully'); window.location.href = 'services.php';</script>";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    header("Location: services.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
</head>
<body>
    <h1>Edit Service</h1>
    <form method="POST" action="">
        <label for="tooth_number">Tooth Number (e.g., "Whole Teeth" for Check-Up or Number):</label><br>
        <input type="text" name="tooth_number" value="<?php echo $service['tooth_number']; ?>" required><br><br>

        <label for="service_name">Service Name:</label><br>
        <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>" required><br><br>

        <label for="price">Price:</label><br>
        <input type="number" name="price" step="0.01" value="<?php echo $service['price']; ?>" required><br><br>

        <button type="submit">Update Service</button>
    </form>
    <br><a href="services.php">Back to Services List</a>
</body>
</html>
