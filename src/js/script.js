const signInForm = document.getElementById("signInForm");
const signUpForm = document.getElementById("signUpForm");
const forgotPasswordForm = document.getElementById("forgotPasswordForm");

function showSignIn() {
    signInForm.style.display = "block";
    signUpForm.style.display = "none";
    forgotPasswordForm.style.display = "none";
}

function showSignUp() {
    signInForm.style.display = "none";
    signUpForm.style.display = "block";
    forgotPasswordForm.style.display = "none";
}

function showForgotPassword() {
    signInForm.style.display = "none";
    signUpForm.style.display = "none";
    forgotPasswordForm.style.display = "block";
}