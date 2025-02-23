<?php
include '../Database/db_con.php';
include 'constants/log_event.php'; // Events Happening

// Initialize error message variable
$error_message = '';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Do not hash the password here

    // Fetch the user data from the database
    $check_user_query = "SELECT * FROM users WHERE email='$email'";
    $user_result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($user_result) == 1) {
        // User found
        $user_data = mysqli_fetch_assoc($user_result);
<<<<<<< HEAD
        session_start();
        $_SESSION['email'] = $email; // Store user email in session variable
        $_SESSION['name'] = $user_data['name']; // Store user name in session variable
<<<<<<< HEAD
=======
        $_SESSION['id_number'] = $user_data['id_number']; // Store id_number in session variable
>>>>>>> 2546f13 (Changes on the site)
        header("Location: home.php"); // Redirect to home page
        exit();
=======

        // Verify the password
        if (password_verify($password, $user_data['password'])) {
            // Password is correct, log the user in
            // Update the logged_in column for the user
            $update_logged_in_query = "UPDATE users SET logged_in = 1 WHERE email = '$email'";
            mysqli_query($conn, $update_logged_in_query);
            
            session_start();
            $_SESSION['email'] = $email; // Store user email in session variable
            $_SESSION['name'] = $user_data['name']; // Store user name in session variable
            $_SESSION['id_number'] = $user_data['id_number']; // Store id_number in session variable
            
            // Log the login event
            log_event($email, 'User logged in');
            
            header("Location: home.php"); // Redirect to home page
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid email or password. Please try again.";
        }
>>>>>>> 4f059c1 (Made changes for our files)
    } else {
        // User not found
        $error_message = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-container">
    <h1 class="login-header">Log In</h1>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <p>Welcome back! Please log in to continue.</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="email" name="email" placeholder="Email" required class="form-input">
        <input type="password" name="password" placeholder="Password" required class="form-input">
        <button type="submit" class="login-button">Login</button>
    </form>
    <p class="register-text">Don't have an account? <a href="signup.php">Sign Up</a></p>
    <p class="forgot-password"><a href="forgot_password.php">Forgot Password</a></p>
</div>
</body>
</html>
