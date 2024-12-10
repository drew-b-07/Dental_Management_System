<?php
include_once 'config/settings-configuration.php';

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $csrf_token = $_SESSION['csrf_token'];

    try {
        $db = new Database();
        $pdo = $db->dbConnection();
        $stmt = $pdo->prepare('SELECT * FROM user WHERE verify_status IS NULL');
        $stmt->execute();

         if ($stmt->rowCount() === 0) {
            echo "<script>alert('Invalid action.'); window.location.href = 'index.php';</script>";
            exit;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="icon" type="image/x-icon" href="src/img/icon.png">
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <div class="main_container">
        <div class="container_form">
            <div class="top_title">
                <h2>OTP VERIFICATION</h2>
            </div>
            <form action="dashboard_user/user/authentication_user/user-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <div class="input_container">
                <input type="number" name="otp" required placeholder="Enter OTP" ><br>
                </div>
                <button type="submit" name="btn-verify-user">VERIFY</button>
            </form>
        </div>
    </div>
</body>
</html>