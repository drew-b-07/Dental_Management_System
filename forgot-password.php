<?php

require_once __DIR__."/config/settings-configuration.php";

if(isset($_SESSION["adminSession"])) {
    echo "<script>alert('admin is log in.'); window.location.href = './dashboard/admin/home.php';</script>";
    exit;
}
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
        <h2>Forgot Password</h2>
        <form method="POST" action="dashboard/admin/authentication/admin-class.php">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="email">Enter your registered email:</label>
            <input class="email" type="email" name="email" required>
            <button type="submit" name="btn-forgot-password">Send Reset Link</button>
        </form>

        

    </div>
</body>
</html>