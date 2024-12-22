<?php
require_once __DIR__."/../../config/settings-configuration.php";
require_once '../user-class.php';

if(!isset($_SESSION["userSession"])) {
    echo "<script>alert('user is not logged in yet.'); window.location.href = '../../';</script>";
    exit;
}

$getUserDetails = new USER();
$userDetails = $getUserDetails->getUserDetails($_SESSION["userSession"]);
$username = $userDetails['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | About Us</title>
    <link rel="stylesheet" href="../../src/css/about.css">
    <link rel="icon" type="image/png" href="../../src/img/icon.png">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <h1>Dental Care Clinic</h1>
            </div>
            <ul>
                <li><a href="./home.php" class="haber">Home</a></li>
                <li><a href="./appointment.php" class="haber">Appointment</a></li>
                <li><a href="./service.php" class="haber">Service</a></li>
                <li><a href="#" class="active">About Us</a></li>
                <li><button onclick="Ulogout()">Logout</button></li>
                <li><h1 class="user">User: <?php echo htmlspecialchars($username); ?></h1></li>
            </ul>
        </nav>
    </header>

    <section class="about-content">
        <h1>About Us</h1>
        <p>Dental Care Clinic, we are dedicated to providing exceptional dental care in a comfortable 
            and welcoming environment. Our team of experienced professionals is committed to helping you achieve 
            and maintain a healthy, beautiful smile for life.
        </p> 

        <h2>Why Choose Us? </h2>
        <p> Comprehensive Care: From routine checkups to advanced treatments, we offer a full range of services tailored to your needs.
        State-of-the-Art Technology: Our clinic is equipped with modern tools to ensure accurate diagnoses and effective treatments.
        Patient-Centered Approach: Your comfort and satisfaction are our top priorities. We take the time to understand your concerns and create personalized treatment plans.
        Experienced Team: Our skilled dentists and friendly staff are passionate about providing the highest standard of care. </p> 

        <h2>Our Services</h2>
        <h3>We specialize in:</h3>
            <p> TMJ Disorders</p> 
            <p> Oral Cancer Screening </p>

        <h2>Our Mission</h2>
        <p>To create healthier, happier smiles by delivering quality dental care with compassion and expertise.</p>

        <div class="clinic-info">
            <h3>Our Clinic</h3>
            <p><strong>Clinic Name:</strong> Dental Care</p>
            <p><strong>Location:</strong> 123 Smile Avenue, Makati City, 1200, Metro Manila, Philippines</p>
            <p><strong>Phone Number:</strong> 09234534581</p>
            <h3>Location</h3>
            <p>
                <a href="https://www.google.com.ph/maps/search/Metro+Manila+dentist/@14.5514664,120.993267,14z?entry=ttu&g_ep=EgoyMDI0MTExOS4yIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer">
                    Google Map
                </a>
            </p>
            
            <h3>Our Team</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="../../src/img/5.jpg" alt="Image" class="team-image">
                    <p><strong>Leader </strong><br>Maria Theresa Garcia</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/1.jpg" alt="Image" class="team-image">
                    <p><strong>Main Coder (Full Stack) </strong><br>Ryan Andrew Bulanadi</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/2.jpg" alt="Image" class="team-image">
                    <p><strong>Frontend </strong><br>Franchezka Octavio</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/7.jpg" alt="Image" class="team-image">
                    <p><strong>Frontend </strong><br>Richi Montemayor</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/5.jpeg" alt="Image" class="team-image">
                    <p><strong>Authentication </strong><br>Joanna Rose Mangiliman</p>
                </div>
            </div>

            <div class="team-members">
                <div class="team-member">
                    <img src="../../src/img/4.jpg" alt="Image" class="team-image">
                    <p><strong>Authentication </strong><br>Kyle Joshua Zablan</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/6.jpg" alt="Image" class="team-image">
                    <p><strong>Frontend </strong><br>Carl Aaron Joshua Lagamayo</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/8.jpg" alt="Image" class="team-image">
                    <p><strong>Frontend </strong><br>Roden Lapuz</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/6.jpeg" alt="Image" class="team-image">
                    <p><strong>ERD & DFD </strong><br>Raul Mendoza</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/3.jpg" alt="Image" class="team-image">
                    <p><strong>ERD & DFD </strong><br>John Del Rosario</p>
                </div>
            </div>
            
        </div>
    </section>

    <script src="../../src/js/script.js"></script>
</body>
</html>