//admin functions
document.addEventListener('DOMContentLoaded', function () {
    const sidebarLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');
    const patientform = document.querySelectorAll('patient-form')
    const patienttable = document.querySelectorAll('patient-table')

    // Function to change active section based on the clicked sidebar link
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            // Remove active class from all sections and nav links
            sections.forEach(section => section.classList.remove('active'));
            sidebarLinks.forEach(link => link.classList.remove('active'));

            // Add active class to the clicked section and link
            const sectionId = this.getAttribute('data-section');
            const activeSection = document.getElementById(sectionId);
            activeSection.classList.add('active');
            this.classList.add('active');
        });
    });


});

//login registration form
function togglePassword(passwordId) {
    const passwordInput = document.getElementById(passwordId);
    const icon = passwordInput.nextElementSibling;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; 
        icon.classList.remove('fa-eye'); 
        icon.classList.add('fa-eye-slash'); 
    } else {
        passwordInput.type = 'password'; 
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function hideAllForms() {
    const forms = ['signUpForm', 'signInForm', 'forgotPasswordForm'];
    forms.forEach(id => {
        const form = document.getElementById(id);
        form.classList.remove('show');
        form.setAttribute('aria-hidden', 'true');
    });
}

function showSignUp() {
    hideAllForms();
    const form = document.getElementById('signUpForm');
    form.classList.add('show');
    form.setAttribute('aria-hidden', 'false');
    document.getElementById('toggle-header').textContent = "REGISTRATION";
}

function showSignIn() {
    hideAllForms();
    const form = document.getElementById('signInForm');
    form.classList.add('show');
    form.setAttribute('aria-hidden', 'false');
    document.getElementById('toggle-header').textContent = "SIGN IN";
}

function showForgotPassword() {
    hideAllForms();
    const form = document.getElementById('forgotPasswordForm');
    form.classList.add('show');
    form.setAttribute('aria-hidden', 'false');
    document.getElementById('toggle-header').textContent = "Forgot Password?";
}

showSignIn();

//log out function
function Ulogout() {
    if(confirm("Are you sure you want to logout?")) {
        location.href = "../../dashboard/user-class.php?user_signout";
    }
}

function logout(){
    if(confirm("Are you sure you want to logout?")) {
        location.href = "../../dashboard/user-class.php?admin_signout";
    }
}