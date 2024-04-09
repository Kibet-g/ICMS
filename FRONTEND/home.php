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
                
                <?php if (isset($_SESSION['name'])): ?>
    <p>Welcome <strong style="color: #00008B;"><?php echo $_SESSION['name']; ?></strong></p>
<?php endif; ?>
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
                    <a href="forgot_password.php">
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
        <div class="categories__item">
            <a href="#">
                <img src="IMAGES/community.svg" alt="Community Engagement">
                <h3>COMMUNITY ENGAGEMENT</h3>
            </a>
        </div>
    </section>
</div>
            </section>
        </div>
    </main>
</body>
</html>
