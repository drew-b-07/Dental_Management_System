<?php
require_once __DIR__."/../../config/settings-configuration.php";
require_once '../user-class.php';

// if(!isset($_SESSION["userSession"])) {
//     echo "<script>alert('user is not logged in yet.'); window.location.href = '../../';</script>";
//     exit;
// }

$getUserDetails = new USER();
$userDetails = $getUserDetails->getUserDetails($_SESSION["userSession"]);
$username = $userDetails['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care | Services</title>
    <link rel="stylesheet" href="../../src/css/service.css">
    <link rel="icon" type="image/png" href="../../src/img/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Quicksand:wght@300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
                <li><a href="#" class="active">Service</a></li>
                <li><a href="./about.php" class="haber">About Us</a></li>
                <li><button onclick="Ulogout()">Logout</button></li>
                <li><h1 class="user">User: <?php echo htmlspecialchars($username); ?></h1></li>
            </ul>
        </nav>
    </header>

    <section class="services">
        <div class="content_container">

            <div class="info_container">
                <h1>Restorative Dentistry</h1>
                <p>Bring back the confidence in your smile with our Restorative Dentistry solutions. Whether you’re 
                    dealing with missing, broken, or decayed teeth, we’ll restore function and aesthetics using 
                    state-of-the-art treatments like crowns, bridges, implants, and dentures. Trust us to give you a 
                    reason to smile again.
                </p>
                    
                <div class="service_image">
                    <img src="../../src/img/service1.jpg" alt="image">
                </div>
 
            </div>

        </div>

    </section>

    <section class="services">
        <div class="content_container">

            <div class="info_container">
                <h1>Pediatric Dentistry</h1>
                <p>Happy smiles start early! Our Pediatric Dentistry services cater specifically to young patients,
                     ensuring a fun, caring, and safe environment. From cavity prevention to orthodontic evaluations,
                      we’ll keep your child’s teeth healthy and strong while building their confidence in dental visits.
                </p>
                    
                <div class="service_image">
                    <img src="../../src/img/service2.jpg" alt="image">
                </div>
 
            </div>

        </div>

    </section>

    <section class="services">
        <div class="content_container">

            <div class="info_container">
                <h1>Orthodontics</h1>
                <p>Straighten up for a smile that shines! With our expert Orthodontic treatments, 
                    including braces and aligners, we’ll help you achieve perfectly aligned teeth and a balanced bite.
                     Whether you’re correcting minor issues or need comprehensive care, our specialists have the skills
                      to make your dream smile a reality.
                </p>
                    
                <div class="service_image">
                    <img src="../../src/img/service3.jpg" alt="image">
                </div>
 
            </div>

        </div>

    </section>

    <section class="services">
        <div class="content_container">

            <div class="info_container">
                <h1>Contouring and Reshaping</h1>
                <p>With our Contouring and Reshaping Services, we’ll transform your smile by gently sculpting your teeth 
                    to enhance their natural beauty. Whether you're looking to smooth out uneven edges, correct minor
                     imperfections, or balance the proportions of your teeth, our skilled team uses the latest techniques 
                     to refine your smile. It's a quick, non-invasive treatment that can give you the confident,
                      radiant smile you've always wanted—no need for braces or major dental work. Get ready to shine 
                      with a perfectly contoured smile!

                </p>
                    
                <div class="service_image">
                    <img src="../../src/img/service4.jpg" alt="image">
                </div>
 
            </div>

        </div>

    </section>

    <section class="services">
        <div class="content_container">

            <div class="info_container">
                <h1>Toothaches</h1>
                <p>Don’t let a toothache hold you back! Our Toothache Relief Services are designed to quickly
                     identify the source of your discomfort and provide fast, effective treatment to ease your pain.
                      Whether it’s a cavity, an infection, or gum irritation, our experienced team uses the latest
                       techniques to get you back to feeling your best. From gentle treatments to comprehensive care, 
                       we’ll make sure your smile stays pain-free and healthy. Don’t wait—relieve your toothache today
                        and get back to enjoying life!
                </p>
                    
                <div class="service_image">
                    <img src="../../src/img/service5.jpg" alt="image">
                </div>
 
            </div>

        </div>

    </section>

    <div class="link_button">
            <a href="./appointment.php">
                    <button>BOOK AN APPOINTMENT NOW!</button>
            </a>
    </div>

    <script src="../../src/js/script.js"></script>
</body>
</html>