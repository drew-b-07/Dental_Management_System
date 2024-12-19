<?php
require_once __DIR__ ."/config/settings-configuration.php";

unset($_SESSION['userSession']);
// unset($_SESSION['adminSession']);

    if(isset($_SESSION["userSession"])) {
        echo "<script>alert('user is logged in.'); window.location.href = './dashboard/user/home.php';</script>";
        exit;
    }

    // if(isset($_SESSION["adminSession"])) {
    //     echo "<script>alert('admin is logged in.'); window.location.href = './dashboard/admin/index.php';</script>";
    //     exit;
    // }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | Login and Registration</title>
    <link rel="icon" href="src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./src/css/register.css">
</head>

<body>
    <div class="container">
        <div class="form-container" id="signUpForm" aria-hidden="true">
            <form action="dashboard/user-class.php" id="signUpForm" method="POST">
                <h1>Create Your Account</h1>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
                <input id="name-signup" type="text" name="fullname" placeholder="Full Name" required>
                <input id="email-signup" type="email" name="email" placeholder="Email Address" required>
                <input id="username-signup" type="text" name="username" placeholder="Username" required>

                <div class="password-container">
                    <input id="password-signup" type="password" name="password" placeholder="Password" required>
                    <i class="fas fa-eye" onclick="togglePassword('password-signup')"></i>
                </div>

                <div class="password-container">
                    <input id="confirm-password-signup" type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <i class="fas fa-eye" onclick="togglePassword('confirm-password-signup')"></i>
                </div>

                <button type="submit" name="btn-user-signup">SIGN UP</button>
            </form>
            <div class="link-container">
                <p> <a onclick="showSignIn()">Login here</a></p>
            </div>
        </div>

        <div class="form-container" id="signInForm" aria-hidden="false">
            <form action="dashboard/user-class.php" method="POST">
                <h1>Login to Your Account</h1>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
                <input id="email-signin" type="text" name="username" placeholder="Username" required>

                <div class="password-container">
                    <input id="password-signin" type="password" name="password" placeholder="Password" required>
                    <i class="fas fa-eye" onclick="togglePassword('password-signin')"></i>
                </div>

                <button type="submit" name="btn-signin">SIGN IN</button>
                <div class="link-container">
                    <a onclick="showForgotPassword()">Forgot Password</a>
                    <div class="link-divider"></div>
                    <a onclick="showSignUp()">Sign Up</a>
                </div>
            </form>
        </div>


        <div class="form-container" id="forgotPasswordForm" aria-hidden="true">
            <form action="dashboard/user-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <h1>Forgot Password</h1>
                <input id="email-forgot" type="email" name="email" required placeholder="Enter your email">
                <button type="submit" name="btn-forgot-password">ENTER</button>
                <button onclick="showSignIn()">BACK</button>
            </form>
        </div>

        <div class="toggle-container">
            <img src="./src/img/logo.png" alt="Dental Care Logo" id="logo" class="logo">
            <h1 id="toggle-header"></h1>
        </div>
    </div>

    <script src="./src/js/script.js"></script>
</body>

</html>