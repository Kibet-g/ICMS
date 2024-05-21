<?php
<<<<<<< HEAD
include '../Database/db_con.php';

session_start();

=======
//ONE CANT ACCESS THIS PAGE WITHOUT LOGGING IN
include './constants/authenticator.php';
?>
<?php
include '../Database/db_con.php';

>>>>>>> 2546f13 (Changes on the site)
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // **Validate input fields thoroughly**
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } elseif (strlen($newPassword) < 8) {  // Add password strength check
        $error = "New password must be at least 8 characters long.";
    } else {
        // Check if the old password matches the password stored in the database
        $email = $_SESSION['email']; // Assuming email is stored in the session
        $query = "SELECT password FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);  // Use prepared statements for security
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($oldPassword, $hashedPassword)) {
                // Hash the new password using a strong algorithm
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param('ss', $hashedNewPassword, $email);
                $updateResult = $stmt->execute();

                if ($updateResult) {
                    $success = "Password updated successfully.";
                } else {
                    $error = "Failed to update password. Please try again.";
                }
            } else {
                $error = "Incorrect old password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/forgot_password.css"> <!-- Assuming you have a CSS file for styling -->
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="old_password">Old Password:</label>
            <input type="password" name="old_password" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
