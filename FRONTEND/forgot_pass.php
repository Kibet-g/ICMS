<?php
// Include necessary files
include '../Database/db_con.php';

// Include PHPMailer for email functionality
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Initialize error and success messages
$error = $success = '';

// Check if the forgot password form is submitted
if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        // Generate a temporary password
        $tempPassword = bin2hex(random_bytes(4)); // 8-character temporary password

        // Update the user's password in the database
        $hashedTempPassword = password_hash($tempPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE users SET password = ?, must_change_password = 1 WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ss', $hashedTempPassword, $email);
        $updateResult = $stmt->execute();

        if ($updateResult) {
            // Send email to the user
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'kibetg984@gmail.com'; // SMTP username
                $mail->Password = 'qsgr ffuz syic piuz'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('kibetg984@gmail.com', 'Sondu Police Station');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Temporary Password';
                $mail->Body    = "Your temporary password is: <strong>$tempPassword</strong>. Please log in and change your password.";

                $mail->send();
                $success = 'A temporary password has been sent to your email.';
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Failed to update password. Please try again.";
        }
    } else {
        $error = "Email not found in our records.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgot_password.css"> <!-- Ensure this CSS file exists and is correct -->
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Enter your email address:</label>
            <input type="email" name="email" required>
            <button type="submit" name="forgot_password">Submit</button>
        </form>
    </div>
</body>
</html>
