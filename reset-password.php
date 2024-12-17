<?php

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if(!isset($_GET['token'])){
    echo "<script>alert('No token provided.'); window.location.href = 'index.php';</script>";
    exit;
}

$token = $_GET['token'];

// Optionally, verify the token's existence and validity before showing the form
// This can also be handled in the resetPassword method
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="dashboard/admin/authentication/admin-class.php">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="new_password">Enter your new password:</label>
            <input type="password" name="new_password" required>
            <button type="submit" name="btn-reset-password">Reset Password</button>
        </form>
    </div>
</body>
</html>