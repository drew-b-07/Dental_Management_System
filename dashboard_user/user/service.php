<?php
require_once __DIR__."/../../config/settings-configuration.php";

// if(!isset($_SESSION["adminSession"])) {
//     echo "<script>alert('admin is not log in.'); window.location.href = '../../index.php';</script>";
//     exit;
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | Services</title>
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
                <li><a href="#">Services</a></li>
                <li><a href="./appointment.php">Appointment</a></li>
                <li><a href="./about.php">About Us</a></li>
                <li><a href="#" onclick="logout()">Logout</a></li>
                <li><a href="./profile.php">
                    <div class="profile-icon-button">
                        <img src="../../src/img/profile.jpg" alt=" "class="profile-icon">
                    </div>
                </a></li>
            </ul>
        </nav>
    </header>

    <section class="service-content">
        <h2>Our Services</h2><br>
        <p>We provide a range of dental services to help keep your smile healthy and beautiful.</p><br>
        <div class="service-list">
            <div class="service-item">
                <h3>Teeth Cleaning</h3><br>
                <p>Regular cleanings to remove plaque and tartar and keep your teeth shining bright.</p>
            </div>
            <div class="service-item">
                <h3>Dental Orthodontics</h3><br>
                <p>Improve alignment of teeth and jaws with braces and other treatments.</p>
            </div>
            <div class="service-item">
                <h3>Fixed Bridge</h3><br>
                <p>Restore your smile with our high-quality fixed bridges and crowns.</p>
            </div>
        </div>
    </section>
    <script src="../../src/js/popup-logout.js"></script>
</body>
</html>