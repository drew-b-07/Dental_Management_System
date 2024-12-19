<?php
require_once __DIR__."/../../config/settings-configuration.php";

// if(!isset($_SESSION["userSession"])) {
//     echo "<script>alert('user is not logged in yet.'); window.location.href = '../../';</script>";
//     exit;
// }

// if (isset($_POST['btn-book-appointment'])) {
//     // Include user class or autoload dependencies
//     require_once __DIR__ . "/../../classes/User.php";

//     // Retrieve form data
//     $phone = $_POST['phone'];
//     $appointmentDate = $_POST['appointment_date'];
//     $message = isset($_POST['message']) ? $_POST['message'] : '';

//     // Get user ID from session
//     $userId = $_SESSION['userSession']['id'];

//     // Instantiate User class
//     $user = new User();

//     // Attempt to book the appointment
//     if ($user->bookAppointment($userId, $phone, $appointmentDate, $message)) {
//         echo "<script>alert('Appointment booked successfully!'); window.location.href = './appointment.php';</script>";
//     } else {
//         echo "<script>alert('Failed to book the appointment. Please try again.');</script>";
//     }
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | Appointment</title>
    <link rel="stylesheet" href="../../src/css/appointment.css">
    <link rel="icon" type="image/png" href="../../src/img/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <h1>Dental Care Clinic</h1>
            </div>
            <ul>
                <li><a href="./home.php" class="haber">Home</a></li>
                <li><a href="#" class="active">Appointment</a></li>
                <li><a href="./service.php" class="haber">Service</a></li>
                <li><a href="./about.php" class="haber">About Us</a></li>
                <li><button onclick="Ulogout()">Logout</button></li>
                <a href="./profile.php">
                    <div class="profile-icon-button">
                        <img src="../../src/img/profile.jpg" alt=" " class="profile-icon">
                    </div>
                </a>
            </ul>
        </nav>
    </header>


    <section class="appointment-content">
    <form class="appointment-form" action="submit_appointment.php" method="POST">
        
        <!-- Form Header -->
        <div class="appointment-title">
            <h1>Book Your Appointment</h1>
            <p>Please fill out all the fields.</p>
        </div>
        
        <!-- Form Fields -->
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" required>
        </div>

        <div class="form-group age-group">
            <label>Age:</label>
            <input type="number" name="age" required>
        </div>

        <div class="form-group">
            <label>Birthday:</label>
            <input type="date" name="birthday" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="appointment-date">Preferred Appointment Date & Time:</label>
            <input type="datetime-local" id="appointment-date" name="appointment_date" required>
        </div>

        <div class="form-group message-group">
            <label for="message">Any Additional Information:</label>
            <textarea id="message" name="message" rows="4" placeholder="Optional"></textarea>
        </div>
        
        <div class="btn-book">
            <button type="submit" name="btn-book-appointment">Book Appointment</button>
        </div>

    </form>
</section>


    <script src="../../src/js/script.js"></script>
</body>
</html>