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
    <title>Dental Care | Home</title>
    <link rel="stylesheet" href="../../src/css/home.css">
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
                <li><a href="#" class="active">Home</a></li>
                <li><a href="appointment.php" class="haber">Appointment</a></li>
                <li><a href="./service.php" class="haber">Service</a></li>
                <li><a href="about.php" class="haber">About Us</a></li>
                <li><button onclick="Ulogout()">Logout</button></li>
                <li><h1 class="user">User: <?php echo htmlspecialchars($username); ?></h1></li>
            </ul>
        </nav>
    </header>

    <section class="intro">
        <h2>The Best Accessory You Can Wear is a Healthy Smile</h2>
            <div class="images">
                <img src="../../src/img/page1.jpg" alt=" ">
                <img src="../../src/img/page2.jpg" alt=" ">
                <img src="../../src/img/page3.jpg" alt=" ">
            </div>
            <div class="images">
                <img src="../../src/img/page4.jpg" alt=" ">
                <img src="../../src/img/page5.jpg" alt=" ">
            </div>

                    <!-- New Appointment Button -->
            <div class="appointment-section">
                <button onclick="window.location.href='appointment.php'" class="appointment-button">Make an Appointment</button>
            </div>
    </section>
     
    <section class="slogan_container">
        <h1>Where Smiles Begin and Care Never Ends</h1>
        <div class="slogan_p">
            <p>We are dedicated to your dental health and overall well-being. From the moment you arrive, you’ll 
                experience a welcoming and personalized approach to care. Using advanced technology and a gentle 
                touch, we offer everything from routine cleanings to cosmetic transformations. Our goal is to ensure 
                your comfort and help you achieve a healthy, radiant smile that lasts a lifetime. Your confidence and 
                smile are always our top priorities!</p>
        </div>
        <div class="slogan_logo">
            <img src="../../src/img/logo.png" alt="Logo">
        </div>
    </section>

    <section class="container">
        <div class="display_container">

            <div class="text_container">
                <h1>The Power of Brushing</h1>
                <p>Dentists recommend brushing your teeth for at least two minutes, twice a day,
                    to maintain optimal oral health. This ensures that you are thoroughly cleaning all surfaces of
                    your teeth, including hard-to-reach areas like the back molars. By brushing for the full two minutes,
                    you allow enough time for your toothbrush to effectively remove plaque and food particles
                    from your teeth and gums. Plaque is a sticky, colorless film of bacteria that forms on your
                    teeth and can lead to cavities, gum disease, and bad breath if not removed regularly. 
                    Consistent brushing, along with flossing and routine visits to your dentist, is essential
                    for keeping your mouth clean, healthy, and free from dental problems.</p>
 
            </div>

            <div class="content_container">
                <img src="../../src/img/trivia1.jpg" alt="">
            </div>

        </div>
    </section>

    <section class="container">
        <div class="display_container">

            <div class="content_container">
                <img src="../../src/img/trivia2.jpg" alt="">
            </div>

            <div class="text_container2">
                    <h1>Understanding Cavities</h1>
                    <p>Cavities, also known as dental caries or tooth decay, are small holes or openings that form 
                        in the hard surface of your teeth when harmful bacteria in your mouth produce acids.
                        These acids are a byproduct of the bacteria feeding on food particles, especially sugars 
                        and starches, left on your teeth after eating or drinking. Over time, these acids can erode
                        your tooth enamel—the hard, protective outer layer of your teeth. As the enamel breaks down,
                        the tooth becomes more vulnerable to further decay, which can eventually lead to the formation 
                        of cavities.</p>
            </div>

        </div>
    </section>

    <section class="container">
        <div class="display_container">

            <div class="text_container">
                <h1>Gingivitis</h1>
                <p>Cavities often start small but can grow larger if left untreated, potentially reaching deeper 
                    layers of the tooth, including the dentin (the soft tissue beneath the enamel), and even the pulp
                     (the innermost part of the tooth, which contains nerves and blood vessels). Once a cavity reaches
                      these deeper layers, it can cause pain, sensitivity, and even infection, often requiring more
                       extensive dental treatments such as fillings, crowns, or even root canals to repair the damage.
                </p>

            </div>

            <div class="content_container">
                <img src="../../src/img/trivia3.jpg" alt="">
            </div>

        </div>
    </section>
    
    <section class="container">
        <div class="display_container">

            <div class="content_container">
                <img src="../../src/img/trivia4.jpg" alt="">
            </div>

            <div class="text_container2">
                    <h1>TMJ Disorders</h1>
                    <p>TMJ Disorder Services focus on the diagnosis, treatment, and management of conditions 
                        affecting the temporomandibular joint (TMJ), which connects your jawbone to your skull.
                         This joint plays a crucial role in allowing you to open and close your mouth, chew, speak,
                          and perform other jaw movements. When the TMJ becomes misaligned, injured, or affected by
                           conditions such as arthritis or jaw clenching, it can lead to a variety of uncomfortable symptoms,
                            including jaw pain, headaches, difficulty chewing, earaches, and clicking or popping sounds 
                            when opening or closing the mouth.</p>
                            <div class="link_button2">
                                    <a href="./appointment.php">
                                        <button>BOOK APPOINTMENT</button>
                                    </a>
                            </div>
                              
            </div>

        </div>
    </section>

    <section class="container">
        <div class="display_container">

            <div class="text_container">
                <h1>Oral Cancer Screening</h1>
                <p>Oral Cancer Screening Services involve the routine examination of the mouth, lips, 
                    tongue, gums, and throat to detect early signs of oral cancer. The goal of these services
                     is to identify potential issues before they develop into more serious, hard-to-treat conditions.
                      Oral cancer, which includes cancers of the lips, tongue, floor of the mouth, and soft tissues
                       of the oral cavity, can often be painless in its early stages, making regular screenings
                        essential for early detection and improved treatment outcomes.</p>
                        <div class="link_button">
                                    <a href="./appointment.php">
                                        <button>BOOK APPOINTMENT</button>
                                    </a>
                        </div>
            </div>

            <div class="content_container">
                <img src="../../src/img/trivia5.jpg" alt="">
            </div>

        </div>
    </section>

   

    <footer>
        
    </footer>

    <script src="../../src/js/script.js"></script>
</body>
</html>