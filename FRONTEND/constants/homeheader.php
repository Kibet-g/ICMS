<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
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
                
                    <i class="fas fa-cog"></i> <!-- Font Awesome settings icon -->
                    Settings
                
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
                    <a href="view_details.php">
                        <i class="fas fa-user"></i> <!-- Font Awesome user icon -->
                        View Details
                    </a>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> <!-- Font Awesome sign-out icon -->
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>
    
</body>
</html>