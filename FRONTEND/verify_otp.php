<?php
session_start();
include '../Database/db_con.php';
include 'constants/log_event.php'; // Events Happening

// Initialize error message variable
$error_message = '';

if (isset($_POST['otp'])) {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $email = $_SESSION['email']; // Retrieve email from session

    // Check if the OTP is valid
    $check_otp_query = "SELECT * FROM users WHERE email='$email' AND otp='$otp' AND otp_expiration > NOW()";
    $otp_result = mysqli_query($conn, $check_otp_query);

    if (mysqli_num_rows($otp_result) == 1) {
        // OTP is valid
        $update_user_query = "UPDATE users SET is_verified = 1, otp = NULL, otp_expiration = NULL WHERE email = '$email'";
        mysqli_query($conn, $update_user_query);

        // Log the OTP verification event
        log_event($email, 'User verified their email');

        $_SESSION['success_message'] = "Email verified successfully!";
        header("Location: login.php");
        exit();
    } else {
        // OTP is invalid or expired
        $error_message = "Invalid or expired OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify OTP</title>
<link rel="stylesheet" href="css/verify_otp.css">
</head>
<body>
<div class="verify-otp-container">
    <h1 class="verify-otp-header">Verify OTP</h1>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <p>Please enter the OTP sent to your email.</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="text" name="otp" placeholder="OTP" required class="form-input">
        <button type="submit" class="verify-otp-button">Verify</button>
    </form>
</div>
</body>
</html>
