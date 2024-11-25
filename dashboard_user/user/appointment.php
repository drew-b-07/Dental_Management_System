<?php
require_once __DIR__."/../../config/settings-configuration.php";

// if(!isset($_SESSION["adminSession"])) {
//     echo "<script>alert('admin is not logged in.'); window.location.href = '../../index.php';</script>";
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | Appointment</title>
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
                <li><a href="./appointment.php" class="active">Appointment</a></li>
                <li><a href="./about.php">About Us</a></li>
                <li><a href="#" onclick="logout()">Logout</a></li>
                <li><a href="./profile.php">
                    <div class="profile-icon-button">
                        <img src="../../src/img/profile.jpg" class="profile-icon">
                    </div>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="appointment-content">
    <h2>Book Your Appointment</h2>
    <p>We are excited to help you maintain a healthy and beautiful smile. Please fill out the form below to schedule your appointment:</p>

    <form class="appointment-form" action="submit_appointment.php" method="POST">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>
        
        <label for="appointment-date">Preferred Appointment Date & Time:</label>
        <input type="datetime-local" id="appointment-date" name="appointment_date" required>
        
        <label for="message">Any Additional Information:</label>
        <textarea id="message" name="message" rows="4" placeholder="Optional"></textarea>
        
        <button type="submit">Book Appointment</button>
    </form>
    </section>

    <script src="../../src/js/popup-logout.js"></script>
</body>
</html>