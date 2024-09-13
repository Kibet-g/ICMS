<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sondu Police Station</title>
    <link rel="stylesheet" href="landing/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Include the updated dropdown CSS here */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 200px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 8px;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .dropdown-content p {
            margin: 0;
            padding: 8px 0;
            color: #333;
        }

        .dropdown-content p:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="landing/images/sondu_logo.png" alt="Sondu Police Station Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">About Us</a>
                    <div class="dropdown-content">
                        <p>We are dedicated to maintaining peace and order in our community. Our mission is to provide high-quality policing services and ensure the safety and security of the citizens we serve.</p>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Contact Us</a>
                    <div class="dropdown-content">
                        <p>P.O. Box P.O. Box 48 – 40109 Sondu, Kenya</p>
                        <p>Phone: 020-3532162</p>
                        <p>Email: sondustation@sondu.police</p>
                    </div>
                </li>
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
            <?php include 'landing/constants/police_on_duty.php'; ?>
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
                    <p>No we dont accept anonymous case or crime occurence reporting One must login to the system to report an incidents.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">What should I do if I lost my belongings?</button>
                <div class="faq-answer">
                    <p>If you lost your belongings, you should file a lost property report at our station or through our online system.</p>
                </div>
            </div>
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
</body>
</html>
