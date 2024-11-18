<?php
session_start();

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
    <title>Contact - Dental Care</title>
    <link rel="stylesheet" href="../../src/css/allpages.css">
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
                <li><a href="#">Contact</a></li>
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

    <section class="contact-content">
        <h2>Contact Us</h2><br>
        <p>We'd love to hear from you! Please reach out with any questions or to book an appointment.</p><br>
        <form class="contact-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea><br> 
        </form>

        <button type="submit">Send Message</button> 
    </section>
    <script src="../../src/js/popup-logout.js"></script>

</body>
</html>