<?php
include_once 'config/settings-configuration.php';

// if(isset($_SESSION["userSession"])) {
//     echo "<script>alert('user is log in.'); window.location.href = './dashboard_user/user/home.php';</script>";
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="icon" type="image/png" href="src/img/logo1.png">
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Enter OTP</h1>
        <form action="dashboard_user/user/authentication_user/user-class.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
            <input type="number" name="otp" placeholder="Enter OTP" required><br>
            <button type="submit" name="btn-verify-user">VERIFY</button>
        </form>
    </div>
</body>
</html>