<?php
include '../Database/db_con.php';
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
        <?php if(!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
            if(!pass)
        <?php endif; ?>
        <p>Welcome back! Please log in to continue.</p>
        <form action="login_process.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="login-button">Login</button>
        </form>
        <p class="register-text">Don't have an account? <a href="signup.php">Sign Up</a></p>
        <p class="forgot-password"><a href="forgot_password.php">Forgot Password</a></p>
    </div>
</body>
</html>
