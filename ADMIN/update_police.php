<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Define variables to store form data
$police_id = '';
$error_message = '';
$success_message = '';

// Function to generate a random password
function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $police_id = mysqli_real_escape_string($conn, $_POST['police_id']);
    $police_email = mysqli_real_escape_string($conn, $_POST['police_email']);

    // Generate a random password
    $randomPassword = generateRandomPassword();

    // Update the police record with new email and password
    $update_query = "UPDATE police SET police_email = '$police_email', password = '$randomPassword' WHERE police_id = '$police_id'";
    
    if (mysqli_query($conn, $update_query)) {
        // Retrieve police officer details for email
        $select_query = "SELECT * FROM police WHERE police_id = '$police_id'";
        $result = mysqli_query($conn, $select_query);
        
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            
            // Send email with new password
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
                $mail->addAddress($police_email, $name); // Add a recipient

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your New Password';
                $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; color: #333;'>
                        <h2>Your New Password</h2>
                        <p>Dear $name,</p>
                        <p>Your new password is: <strong>$randomPassword</strong></p>
                        <p>Please change it after logging in.</p>
                        <p>Best regards,</p>
                        <p>Sondu Police Station</p>
                    </div>";

                $mail->send();

                // Set success message after email is sent
                $success_message = "Details updated successfully! Temporary password sent to the email.";
            } catch (Exception $e) {
                // Error sending email
                $error_message = "Error sending email: {$mail->ErrorInfo}";
            }
        } else {
            $error_message = "Error: Police officer not found.";
        }
    } else {
        $error_message = "Error updating details: " . mysqli_error($conn);
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
    <title>Update Police Officer</title>
    <link rel="stylesheet" href="css/update_police.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $error_message; ?>'
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $success_message; ?>'
            });
        </script>
    <?php endif; ?>
</body>
</html>
