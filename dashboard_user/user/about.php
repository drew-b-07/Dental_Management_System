<?php
require_once __DIR__."/../../config/settings-configuration.php";

if(!isset($_SESSION["userSession"])) {
    echo "<script>alert('user is not logged in yet.'); window.location.href = '../../';</script>";
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
    <link rel="icon" type="image/png" href="../../src/img/icon.png">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <h1>Dental Care</h1>
            </div>
            <ul>
                <li><a href="./home.php">Home</a></li>
                <li><a href="./appointment.php">Appointment</a></li>
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
        <p>Welcome to Dental Care, a cutting-edge Dental Care Management System designed to streamline operations for dental practices, enhance patient care, and optimize workflow efficiency.</p>
        <p>Our mission is to empower dental professionals with intuitive tools that simplify practice management, improve patient engagement, and deliver exceptional care with ease.</p>

        <div class="clinic-info">
            <h3>Our Clinic</h3>
            <p><strong>Clinic Name:</strong> Dental Care</p>
            <p><strong>Location:</strong> 123 Smile Avenue, Makati City, 1200, Metro Manila, Philippines</p>
            <p><strong>Phone Number:</strong> 09234534581</p>
            
            <h3>Our Team</h3>
            <div class="team-members">
                <div class="team-member">
                    <img src="../../src/img/denstist.jpeg" alt="Dr. Johnson" class="team-image">
                    <p><strong>Head Dentist:</strong> Dr. Johnson, DDS</p>
                </div>
                <div class="team-member">
                    <img src="../../src/img/assisstant.jpg" alt="Emily Clark" class="team-image">
                    <p><strong>Dental Assistant:</strong> Emily Clark</p>
                </div>
            </div>
            
            <h3>Location</h3>
            <p>
                <a href="https:www.google.com.ph/maps/search/Metro+Manila+dentist/@14.5514664,120.993267,14z?entry=ttu&g_ep=EgoyMDI0MTExOS4yIKXMDSoASAFQAw%3D%3D" target="_blank">
                    Google Map
                </a>
            </p>
        </div>
    </section>

    <script src="../../src/js/user_functions.js"></script>
</body>
</html>