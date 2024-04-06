<?php
// Start session to access session variables
session_start();

// Check if user is logged in, if not, redirect to login page
if (isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Stop script execution after redirect
}
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
    <header>
        <div class="container">
            <div class="header__logo">
                <img src="IMAGES/sondu_logo.png" alt="Sondu Police Station Logo">
            </div>
            <div class="home_image">
                <img src="IMAGES/homepage_banner.svg" alt="Large Image">
                <h1>Welcome to the Sondu Police Station UTUMISHI KWA WOTE</h1>
            </div>

            <div class="settings">
    <a href="#" id="settings-toggle">
        <i class="fas fa-cog"></i> <!-- Font Awesome settings icon -->
        Settings
    </a>
    <div class="dropdown-content" id="settings-dropdown">
        <!-- JavaScript for the dropdown -->
        <script>
            function toggleDropdown() {
                var dropdown = document.getElementById("settings-dropdown");
                if (dropdown.style.display === "none" || dropdown.style.display === "") {
                    dropdown.style.display = "block";
                } else {
                    dropdown.style.display = "none";
                }
            }

            document.getElementById("settings-toggle").addEventListener("click", toggleDropdown);
        </script>

        <!-- Dropdown content -->
        <a href="change_password.php">
            <i class="fas fa-lock"></i> <!-- Font Awesome lock icon -->
            Change Password
        </a>
        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i> <!-- Font Awesome sign-out icon -->
            Logout
        </a>
        <a href="view_details.php">
            <i class="fas fa-user"></i> <!-- Font Awesome user icon -->
            View Details
        </a>
    </div>
</div>
</div>

        </div>
    </header>
    <main>
        <div class="container">
            <section class="categories">
                <h2>CATEGORIES</h2>
                <div class="categories__item">
                    <a href="#">
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
            </section>
        </div>
    </main>
</body>
</html>
