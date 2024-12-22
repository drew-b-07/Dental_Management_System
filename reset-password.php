<?php

require_once __DIR__ ."/database/dbconnection.php";
require_once __DIR__ . "/config/settings-configuration.php";


   if(isset($_SESSION["userSession"])) {
       echo "<script>alert('user is log in.'); window.location.href = './dashboard/user/home.php';</script>";
       exit;
   }

   if(!isset($_GET['tokencode'])){
       echo "<script>alert('No token provided.'); window.location.href = 'index.php';</script>";
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

//    $token = $_GET['tokencode'];

/* NOT USED*/
//  $user = $stmt->fetch(PDO::FETCH_ASSOC);

//    if($_GET['tokencode'] !== $user['tokencode']) {
//        echo "<script>alert('Invalid Tokencode'); window.location.href = 'index.php'";
//        exit();
//    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="icon" type="image/x-icon" href="src/img/icon.png">
    <link rel="stylesheet" href="https:cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <div class="main_container">
        <div class="container_form">
            <div class="top_title">
            <h2>RESET PASSWORD</h2>
            </div>
            <form method="POST" action="dashboard/user-class.php">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <label for="new_password">Enter your new password:</label>

                <div class="input_container">
                <input id="password_reset" type="password" name="new_password" required>
                <i class="fas fa-eye" onclick="togglePassword('password_reset')"></i>
                </div>

                <button type="submit" name="btn-reset-password">CONFIRM</button>
            </form>
        </div>
    </div>
    <script src="./src/js/script.js"></script>
</body>
</html>