<?php
// Start the session
session_start();

// Include the database connection
include '../Database/db_con.php';

// Define an empty error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get admin ID and password from the form
    $admin_id = mysqli_real_escape_string($conn, $_POST['adminid']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query to fetch admin details from the database
    $sql = "SELECT * FROM admin WHERE admin_id = '$admin_id' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if the admin exists and the password is correct
    if (mysqli_num_rows($result) == 1) {
        // Admin is authenticated, set session variables
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['loggedin'] = true;
        
        // Redirect to admin page
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Invalid admin ID or password
        $error_message = "Invalid admin ID or password. Please try again.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> ADMIN</title>
<link rel="stylesheet" href="css/admin_login.css" />
</head>
<body>
<div class="login-container">
<img src="images/sondu_logo.png" alt=""/>
    <h1 class="login-header">ADMIN Log In</h1>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <p>Hello ADMIN Please log in to continue.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="adminid" name="adminid" placeholder="ADMIN ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="login-button">Login</button>
    </form>
</div>
</body>
</html>
