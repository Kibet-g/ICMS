<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

include '../Database/db_con.php';
?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/ICMSSYSTEM/FRONTEND/constants/homeheader.php";
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
</head>
<body>
    <main>
        <div class="container">
            <section class="categories">
                <h2>CATEGORIES</h2>
                <div class="categories__item">
                    <a href="report.php">
                        <img src="IMAGES/reportcase.svg" alt="Report Case/Incident">
                        <h3>REPORT CASE/INCIDENT</h3>
                    </a>
                </div>
                <div class="categories__item">
                    <a href="#">
                        <img src="IMAGES/track_case.svg" alt="Track Case">
                        <h3>TRACK CASE</h3>
                    </a>
                </div>
                <div class="categories__item">
                    <a href="#">
                        <img src="IMAGES/view_ob.svg" alt="View OB Number">
                        <h3>VIEW/ DOWNLOAD OB NUMBER</h3>
                    </a>
                </div>
                <div class="categories__item">
                    <a href="#">
                        <img src="IMAGES/community.svg" alt="Community Engagement">
                        <h3>COMMUNITY ENGAGEMENT</h3>
                    </a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>