<?php
include '../Database/db_con.php';
include 'constants/log_event.php'; // Ensure this file exists and is correct

// Initialize error message variable
$error_message = '';

// Check if email and password are set
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Fetch the user data from the database
    $check_user_query = "SELECT * FROM users WHERE email='$email'";
    $user_result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($user_result) == 1) {
        // User found
        $user_data = mysqli_fetch_assoc($user_result);

        // Verify the password
        if (password_verify($password, $user_data['password'])) {
            // Check if the user must change their password
            if ($user_data['must_change_password'] == 1) {
                // Redirect to change password page
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user_data['name'];
                $_SESSION['id_number'] = $user_data['id_number'];
                $_SESSION['must_change_password'] = true;
                
                header("Location: change_password.php");
                exit();
            } else {
                // Password is correct, log the user in
                $update_logged_in_query = "UPDATE users SET logged_in = 1 WHERE email = '$email'";
                mysqli_query($conn, $update_logged_in_query);
                
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user_data['name'];
                $_SESSION['id_number'] = $user_data['id_number'];
                
                log_event($email, 'User logged in');
                
                header("Location: home.php");
                exit();
            }
        } else {
            // Password is incorrect
            $error_message = "Invalid email or password. Please try again.";
        }
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
<link rel="stylesheet" href="css/login.css"> <!-- Ensure this CSS file exists and is correct -->
</head>
<body>
<div class="login-container">
    <h1 class="login-header">Log In</h1>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <p>Welcome back! Please log in to continue.</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="email" name="email" placeholder="Email" required class="form-input">
        <input type="password" name="password" placeholder="Password" required class="form-input">
        <button type="submit" class="login-button">Login</button>
    </form>
    <p class="forgot-password">
        <a href="forgot_pass.php">Forgot Password</a>
    </p>
    <p class="register-text">Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>
</body>
</html>
