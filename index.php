<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care || Login and Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body>
    <div class="container">
        <div class="toggle-container">
            <img src="./src/img/dental-logo.png" alt="Dental Care Logo" id="logo" class="logo">
            <h1 id="toggle-header">Hello, Friend!</h1>
            <button onclick="showSignIn()">Login</button>
            <button onclick="showSignUp()">Create Account</button>
        </div>

        <div class="form-container" id="signUpForm" aria-hidden="true">
            <form>
                <h1>Create Your Account</h1>
                <label for="name-signup">Full Name</label>
                <input id="name-signup" type="text" name="user_fullname" placeholder="Full Name" required>
                <label for="email-signup">Email Address</label>
                <input id="email-signup" type="email" name="user_emailaddress" placeholder="Email Address" required>
                <label for="username-signup">Username</label>
                <input id="username-signup" type="text" name="user_name" placeholder="Username" required>
                <label for="password-signup">Create Password</label>
                <input id="password-signup" type="password" name="user_createpassword" placeholder="Create Password" required>
                <label for="confirm-password-signup">Confirm Password</label>
                <input id="confirm-password-signup" type="password" name="user_confirmpassword" placeholder="Confirm Password" required>
                <button type="submit" name="btn-user-signup">SIGN UP</button>
            </form>
            <div class="link-container">
                <p>Already have an account? <a href="#" onclick="showSignIn()">Login here</a></p>
            </div>
        </div>
        
        <div class="form-container" id="signInForm" aria-hidden="false">
            <form>
                <h1>Login to Your Account</h1>
                <label for="email-signin">Email Address</label>
                <input id="email-signin" name="user_email" type="email" placeholder="Email Address" required>
                <label for="password-signin">Password</label>
                <input id="password-signin" type="password" name="user_password" placeholder="Password" required>
                <button type="submit" name="btn-user-signin">SIGN IN</button>
                <div class="link-container">
                    <a href="#" onclick="showForgotPassword()">Forgot Password</a>
                </form>
                </div>
        
        <div class="form-container" id="forgotPasswordForm" aria-hidden="true">
            <form>
                <h1>Forgot Password</h1>
                <label for="email-forgot">Enter your email</label>
                <input id="email-forgot" type="email" placeholder="Enter your email" required>
                <button type="submit">Enter</button>
            </form>
        </div>

    <script src="src/js/script.js"></script>
</body>

</html>