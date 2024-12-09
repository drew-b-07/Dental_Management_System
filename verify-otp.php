<?php
include_once 'config/settings-configuration.php';

     $db = new Database();
     $pdo = $db->dbConnection();
     $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
     $stmt->execute([':id' => $_GET['id']]);

     if ($stmt->rowCount() == 0 || $stmt->fetch()['verify_status'] == 'verified') {
        echo "<script>alert('Invalid action. Please sign up first or the OTP is already verified.'); window.location.href = 'index.php';</script>";
        exit;
    } else {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE verify_status = 'not_verified'");
        $stmt->execute([':verify_status' => $_GET['verify_status']]);
        if($stmt->rowCount() == 1) {
            header("Location: verify-otp.php");
            exit;
        }
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