<?php
    include_once 'config/settings-configuration.php';
    if (isset($_SESSION['adminSession'])){
        header('Location: dashboard/admin/');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form || Macro</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body>
<div id="wrapper">
    <div id="container" class="container">
        <div class="form-container sign-in-container">
            <h1>Sign In</h1>
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
                <input type="email" name="email" placeholder="Enter Your Email" required> <br>
                <input type="password" name="password" placeholder="Enter Your Password" required> <br>
                <button class="btnsub" type="submit" name="btn-signin">SIGN IN</button>
            </form>
        </div>

        <div class="form-container sign-up-container">
            <h1>Sign Up</h1>
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
                <input type="text" name="username" placeholder="Enter Your Username" required> <br> 
                <input type="email" name="email" placeholder="Enter Your Email" required> <br>
                <input type="password" name="password" placeholder="Enter Your Password" required> <br>
                <button class="btnsub" type="submit" name="btn-signup">SIGN UP</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome!</h1>
                    <p>Register your account to create an account.</p>
                    <br>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello There!</h1>
                    <p>Sign in your account here.</p>
                    <br>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="src/js/main.js"></script>
</body>
</html>