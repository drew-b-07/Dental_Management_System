<?php

require_once __DIR__."/config/settings-configuration.php";

// if(isset($_SESSION["adminSession"])) {
//     echo "<script>alert('admin is log in.'); window.location.href = './dashboard/admin/home.php';</script>";
//     exit;
// }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="icon" type="image/png" href="src/img/logo1.png">
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="dashboard_user/user/authentication_user/user-class.php">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <h2>Forgot Password</h2>
            <input class="email" type="email" name="email" required placeholder="Enter Registered Email">
            <button type="submit" name="btn-forgot-password">Send Reset Link</button>
        </form>

        

    </div>
</body>
</html>