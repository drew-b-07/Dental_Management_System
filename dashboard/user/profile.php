<?php
require_once __DIR__."/../../config/settings-configuration.php";


if(!isset($_SESSION["userSession"])) {
    echo "<script>alert('user is not logged in yet.'); window.location.href = '../../';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | Profile</title>
    <link rel="stylesheet" href="../../src/css/profile.css">
    <link rel="icon" type="image/png" href="../../src/img/icon.png">
</head>
<body>
    <div class="profile-container">
        <h2>PROFILE</h2>
        <form action="../user-class.php" name="user_profile" method="POST">
            <div class="form-group">
                <label for="fullname">Full Name: </label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($userProfile['fullname'] ?? ''); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userProfile['username'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email Address: </label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userProfile['email'] ?? ''); ?>" readonly>
            </div>

            <div class="button-container">
                <button type="button" class="back-button" onclick="window.location.href='home.php'">BACK</button>
                <button type="submit" class="submit-button">EDIT PROFILE</button>
            </div>
        </form>
    </div>
    <script src="../../src/js/script.js"></script>
</body>
</html>