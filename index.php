<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sondu Police Station</title>
    <link rel="stylesheet" href="landing/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<<<<<<< HEAD
<?php include $_SERVER['DOCUMENT_ROOT'] . '/ICMSSYSTEM/FRONTEND/constants/header.php'; ?>

<<<<<<< HEAD
<marquee behavior="scroll" direction="left" scrollamount="5">WELCOME TO SONDU POLICE STATION WHERE WE SERVE EVERYONE EQUALLY FOR THE TO CATER FOR ALL YOUR NEEDS <br> GET STARTED NOW AND REPORT CRIME ANONYMOUSLY</marquee>
=======
<marquee behavior="scroll" direction="left" scrollamount="5">WELCOME TO SONDU POLICE STATION WHERE WE SERVE EVERYONE EQUALLY #UTUMISHI KWA WOTE<br> GET STARTED NOW AND REPORT CRIME FICHUA CRIME</marquee>
>>>>>>> 2546f13 (Changes on the site)
<div class="large-image">
  <img src="FRONTEND/IMAGES/homepage_banner.svg" alt="Large Image">
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/ICMSSYSTEM/FRONTEND/constants/footer.php'; ?>
=======
    <header>
        <div class="logo">
            <img src="landing/images/sondu_logo.png" alt="Sondu Police Station Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Careers</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <button onclick="location.href='FRONTEND/login.php'">Login</button>
            <button onclick="location.href='FRONTEND/signup.php'">Sign Up</button>
        </div>
    </header>
    <main>
        <section class="hero">
            <img src="landing/images/homepage_banner.svg" alt="Sondu Police Station">
            <div class="welcome-text">
                <h1>Welcome to Sondu Police Station Incidence and Crime Management System</h1>
                <p>You can report crime, track crime incidences, and view crime reports.</p>
            </div>
        </section>
        <section class="police">
            <h2>Police on Duty</h2>
            <div id="criminals-container">
                <!-- Police on duty data will be fetched and displayed here -->
            </div>
        </section>
        <section class="faqs">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <button class="faq-question">How does one report a case?</button>
                <div class="faq-answer">
                    <p>You can report a case by visiting our station, calling our hotline, or using our online reporting system.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">What should I do if I witness a crime?</button>
                <div class="faq-answer">
                    <p>If you witness a crime, you should contact the police immediately and provide as much detail as possible.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">How can I check the status of my report?</button>
                <div class="faq-answer">
                    <p>You can check the status of your report by logging into our online system or contacting the station directly.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">What types of crimes can be reported online?</button>
                <div class="faq-answer">
                    <p>You can report various types of crimes online, including theft, vandalism, and non-emergency incidents. For emergencies, please call our hotline.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Are anonymous reports accepted?</button>
                <div class="faq-answer">
                    <p>Yes, we accept anonymous reports. However, providing contact information can help us follow up on the case more effectively.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">What should I do if I lost my belongings?</button>
                <div class="faq-answer">
                    <p>If you lost your belongings, you should file a lost property report at our station or through our online system.</p>
                </div>
            </div>
        </section>
    </section>
    <section class="criminals">
        <h2>Notorious Criminals</h2>
        <div id="criminals-container">
        <?php include 'landing/constants/notorious_criminals.php'; ?>
        </div>
    </section>
    </main>
    <footer>
        <div class="social-media">
            <p>Follow us on:</p>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>
    <script src="landing/javascript/index.js"></script>
>>>>>>> 4f059c1 (Made changes for our files)
</body>
</html>
