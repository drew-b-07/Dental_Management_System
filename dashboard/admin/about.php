<?php
require_once __DIR__."/../../config/settings-configuration.php";

if(!isset($_SESSION["adminSession"])) {
    echo "<script>alert('admin is not log in.'); window.location.href = '../../index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | About Us</title>
    <link rel="stylesheet" href="../../src/css/allpages.css">
    <link rel="icon" type="image/png" href="../../src/img/logo1.png">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <h1>Dental Care</h1>
            </div>
            <ul>
                <li><a href="./home.php">Home</a></li>
                <li><a href="./service.php">Service</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="#" >About Us</a></li>
                <li><a href="#" onclick="logout()">Logout</a></li>
                <li><a href="./profile.php">
                    <div class="profile-icon-button">
                        <img src="../../src/img/profile.jpg" alt=" " class="profile-icon">
                    </div>
                </a></li>
            </ul>
        </nav>
    </header>

    <section class="about-content">
        <h2>About Us</h2>
        <p>We are a team of dedicated dental professionals committed to providing top-quality care.</p>
        <p>With years of experience and a focus on patient satisfaction, our goal is to help you achieve a healthy, beautiful smile.</p>


        <div class="clinic-info">
            <h3>Our Clinic</h3>
            <p><strong>Clinic Name:</strong> Dental Care</p>
            <p><strong>Location:</strong> 123 Dental Street, Suite 45, lalam tete</p>
            <p><strong>Phone Number:</strong> 09234534581</p>
            
            <h3>Our Team</h3>
            <p><strong>Head Dentist:</strong> Dr. Sarah Johnson, DDS</p>
            <p><strong>Dental Assistant:</strong> Emily Clark</p>
            
            <h3>Follow Us</h3>
            <p>
                <a href="DentalCare" target="_blank">
                    Like us on Facebook
                </a>
            </p>
        </div>
    </section>
    <script src="../../src/js/popup-logout.js"></script>

</body>
</html>