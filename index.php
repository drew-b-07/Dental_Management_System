<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care || Login and Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./src/css/style.css">
</head>

<body>
    <div class="container">
        <div class="toggle-container">
            <img src="./src/img/dental-logo.png" alt="Dental Care Logo" id="logo" class="logo">
            <h1 id="toggle-header">Hello, Friend!</h1>
            <button onclick="showAdminLogin()">User Admin</button>
            <button onclick="showSignIn()">User Login</button>
            <button onclick="showSignUp()">Create Account</button>
        </div>

        <div class="form-container" id="signUpForm" aria-hidden="true">
            <form>
                <h1>Create Your Account</h1>
                <label for="name-signup">Full Name</label>
                <input id="name-signup" type="text" name="user_fullname" placeholder="Full Name" required>
                
                <label for="email-signup">Email Address</label>
                <input id="email-signup" type="email" name="user_email" placeholder="Email Address" required>
                
                <label for="username-signup">Username</label>
                <input id="username-signup" type="text" name="user_name" placeholder="Username" required>
                
                <label for="password-signup">Create Password</label>
                <div class="password-container">
                    <input id="password-signup" type="password" name="user_createpass" placeholder="Create Password" required>
                    <i class="fas fa-eye" id="toggle-password-signup" onclick="togglePassword('password-signup')"></i>
                </div>

                <label for="confirm-password-signup">Confirm Password</label>
                <div class="password-container">
                    <input id="confirm-password-signup" type="password" name="user_confirmpass" placeholder="Confirm Password" required>
                    <i class="fas fa-eye" id="toggle-password-confirm" onclick="togglePassword('confirm-password-signup')"></i>
                </div>

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
                <input id="email-signin" type="email" name="user_enter_email" placeholder="Email Address" required>
                
                <label for="password-signin">Password</label>
                <div class="password-container">
                    <input id="password-signin" type="password" name="user_enter_pass" placeholder="Password" required>
                    <i class="fas fa-eye" id="toggle-password-signin" onclick="togglePassword('password-signin')"></i>
                </div>

                <button type="submit" name="btn-user-signin">SIGN IN</button>
                <div class="link-container">
                    <a href="#" onclick="showForgotPassword()">Forgot Password</a>
                    <div class="link-divider"></div>
                    <a href="#" onclick="showSignUp()">Sign Up</a>
                </div>
            </form>
        </div>


        <div class="form-container" id="forgotPasswordForm" aria-hidden="true">
            <form>
                <h1>Forgot Password</h1>
                <input id="email-forgot" type="email" placeholder="Enter your email" required>
                <button type="submit">ENTER</button>
            </form>
        </div>
    </div>

    <script src="./src/js/LoginForm.js"></script>
</body>

</html>