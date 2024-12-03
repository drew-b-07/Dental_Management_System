<?php

require_once __DIR__ ."/database/dbconnection.php";
require_once __DIR__ . "/config/settings-configuration.php";


 if(isset($_SESSION["userSession"])) {
     echo "<script>alert('user is log in.'); window.location.href = './dashboard_user/user/home.php';</script>";
     exit;
 }

 if(!isset($_GET['tokencode'])){
     echo "<script>alert('No token provided.'); window.location.href = 'home.php';</script>";
     exit;
 }

     $db = new Database();
     $pdo = $db->dbConnection();
     $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
     $stmt->execute([":id" => $_GET['id']]);

 if($stmt->rowCount() == 0) {
     echo "<script>alert('Invalid Link.'); window.location.href = 'index.php';</script>";
     exit();
 }

     $admin = $stmt->fetch(PDO::FETCH_ASSOC);

 if($_GET['tokencode'] !== $admin['tokencode']) {
     echo "<script>alert('Invalid Tokencode'); window.location.href = 'forgot-password.php'";
     exit();
 }

$token = $_GET['tokencode'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="icon" type="image/png" href="src/img/logo1.png">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="dashboard_user/user/authentication_user/user-class.php">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="new_password">Enter your new password</label><br>
            <input type="password" name="new_password" required>
            <button type="submit" name="btn-reset-password">Reset Password</button>
        </form>
    </div>
</body>
</html>