<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="icon.png" type="image/x-icon">
  <title>Admin | Dental Care</title>
  <link rel="stylesheet" href="./src/css/admin.css">
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
          <form action="#" method="post">
            <input type="text" name="username" id="email" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" name="btn-admin-signin">LOGIN</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
</html>