<?php
//ONE CANT ACCESS THIS PAGE WITHOUT LOGGING IN
include './constants/authenticator.php';
include './constants/homeheader.php';

// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user details from the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$mobile_no = isset($_SESSION['mobile_no']) ? $_SESSION['mobile_no'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sondu Police Station</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
</head>
<body>
    <main>
        <div class="container">
            <section class="categories">
                <h2>CATEGORIES</h2>
                <div class="categories__item">
                    <a href="upload_case.php">
                        <img src="IMAGES/reportcase.svg" alt="Report Case/Incident">
                        <h3>REPORT CASE/INCIDENT</h3>
                    </a>
                </div>
                <div class="categories__item">
                    <a href="track_case.php">
                        <img src="IMAGES/track_case.svg" alt="Track Case">
                        <h3>TRACK CASE</h3>
                    </a>
                </div>

                <div class="categories__item">
                    <a href="case_progress.php">
                    <img src="IMAGES/community.svg" alt="Community Engagement">
                        <h3>CASE PROGRESS</h3>
                    </a>
                </div>
            </section>
</body>
</html>
