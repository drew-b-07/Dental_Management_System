//admin functions
document.addEventListener('DOMContentLoaded', function () {
    const sidebarLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');
    const links = document.querySelectorAll('a');
    const serviceElements = document.querySelectorAll('.display_container');
    const img = document.querySelector(".slogan_logo img");

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

    //page changing animation
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
    
            const href = e.target.getAttribute('href') || e.target.closest('a').getAttribute('href');
    
            if (href) {
                document.body.classList.add('fade-out');
    
                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            }
        });
    });

    const options = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, options);

    serviceElements.forEach(element => {
        observer.observe(element); 
    });

    //animation for fade in
    window.addEventListener('load', function() {
        document.body.classList.add('fade-in');
    });

    //logo animation
    const handleScroll = () => {
        const rect = img.getBoundingClientRect();
        const isVisible = rect.top < window.innerHeight && rect.bottom >= 0;

        if (isVisible) {
            img.classList.add("scrolled");
        }
    };

    document.addEventListener("scroll", handleScroll);
    handleScroll();
});


//login form functions
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
        form.classList.add('hide');
        form.setAttribute('aria-hidden', 'true');
    });
}

function showSignUp() {
    hideAllForms();
    const form = document.getElementById('signUpForm');
    form.classList.remove('hide');
    form.classList.add('show');
    form.setAttribute('aria-hidden', 'false');
}

function showSignIn() {
    hideAllForms();
    const form = document.getElementById('signInForm');
    form.classList.remove('hide');
    form.classList.add('show');
    form.setAttribute('aria-hidden', 'false');
}

function showForgotPassword() {
    hideAllForms();
    const form = document.getElementById('forgotPasswordForm');
    form.classList.remove('hide');
    form.classList.add('show');
    form.setAttribute('aria-hidden', 'false');
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