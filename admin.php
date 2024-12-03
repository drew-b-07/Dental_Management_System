<?php
require_once __DIR__ ."/config/settings-configuration.php";


if(isset($_SESSION["adminSession"])){
  echo "<script>alert('admin is log in.'); window.location.href = './dashboard_admin/admin/calendar.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="src/img/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="./src/css/admin.css">
  <title>Admin | Dental Care</title>
</head>
<body>
  <div id="wrapper">
    <header>
      <button type="submit" onclick="location.href='index.php'"> ⇦ BACK TO MAIN</button>
      <img src="./src/img/logo.png" alt="logo">
    </header>

    <main>
      <div class="first half">
        <img src="./src/img/icon.png" alt="icon">
      </div>
      <div class="second half">
        <div class="login">
          <div class="top">
            <h1>ADMIN</h1>
          </div>
          <form action="dashboard_admin/admin/authentication/admin-class.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" name="btn-admin-signin">LOGIN</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
</html>