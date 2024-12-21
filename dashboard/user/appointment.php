<?php
require_once '../main.php';
require_once '../user-class.php';

$getUserDetails = new USER();
$userDetails = $getUserDetails->getUserDetails($_SESSION["userSession"]);
$username = $userDetails['username'];

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
                <li><h1 class="user">User: <?php echo htmlspecialchars($username); ?></h1></li>
            </ul>
        </nav>
    </header>


    <section class="appointment-content">
    <form class="appointment-form" method="POST">
        
        <!-- Form Header -->
        <div class="appointment-title">
            <h1>Book Your Appointment</h1>
            <p>Please fill out all the fields.</p>
        </div>
        
        <!-- Form Fields -->
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="fullname" required>
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
            <input type="tel" id="phone" name="phone_number" required>
        </div>

        <div class="form-group">
            <label for="appointment-date">Preferred Appointment Date & Time:</label>
            <input type="datetime-local" id="appointment-date" name="pref_appointment" required>
        </div>

        <div class="form-group message-group">
            <label for="message">Any Additional Information:</label>
            <textarea id="message" name="additional_info" rows="4" placeholder="Optional"></textarea>
        </div>
        
        <div class="btn-book">
            <button type="submit" name="btn-book-appointment">Book Appointment</button>
        </div>

    </form>
</section>


    <script src="../../src/js/script.js"></script>
</body>
</html>