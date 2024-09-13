<?php
// Include the database connection
include '../Database/db_con.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

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
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $idtype = mysqli_real_escape_string($conn, $_POST['idtype']);
    $mobile_no = mysqli_real_escape_string($conn, $_POST['mobile_no']);

    // Generate a random password
    $randomPassword = generateRandomPassword();

    // Hash the random password before saving it to the database
    $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);

    // Update the user record with new details and password
    $update_query = "UPDATE users SET name = '$name', email = '$email', idtype = '$idtype', mobile_no = '$mobile_no', password = '$hashedPassword' WHERE id_number = '$id_number'";

    if (mysqli_query($conn, $update_query)) {
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
                    <p>Your Company</p>
                </div>";

            $mail->send();

            // Redirect back to the user management page with a success message
            header("Location: manage_users.php?success=Password updated successfully! Temporary password sent to the email.");
            exit();
        } catch (Exception $e) {
            // Redirect back to the user management page with an error message
            header("Location: manage_users.php?error=Error sending email: {$mail->ErrorInfo}");
            exit();
        }
    } else {
        // Redirect back to the user management page with an error message
        header("Location: manage_users.php?error=Error updating password: " . mysqli_error($conn));
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
