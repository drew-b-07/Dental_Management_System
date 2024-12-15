<?php
include_once 'config/settings-configuration.php';

// if (!isset($_SESSION['userSession'])) {
//     echo "<script>alert('Invalid action.'); window.location.href = 'index.php' ;</script>";
//     exit();
// }

// unset($_SESSION['userSession']);
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