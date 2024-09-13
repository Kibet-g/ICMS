<?php
// Start the session
session_start();

// Include the database connection
include '../Database/db_con.php';

// Define an empty error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get police ID, police email, and password from the form
    $police_id = mysqli_real_escape_string($conn, $_POST['policeid']);
    $police_email = mysqli_real_escape_string($conn, $_POST['policeemail']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch police details from the database
    $sql = "SELECT * FROM police WHERE police_id = '$police_id' AND police_email = '$police_email'";
    $result = mysqli_query($conn, $sql);

    // Check if the police record exists
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Check if the account is within the disabled period
        $current_time = date('Y-m-d H:i:s');
        if ($current_time >= $row['start_disable'] && $current_time <= $row['end_disable']) {
            $error_message = "Your account is currently disabled. Please try again later.";
        } elseif ($password === $row['password']) {  // Assuming the password is stored in plaintext; ideally, it should be hashed
            // Police is authenticated, set session variables
            $_SESSION['police_id'] = $police_id;
            $_SESSION['police_email'] = $police_email;
            $_SESSION['loggedin'] = true;
            
            // Redirect to assigned_cases.php page
            header("Location: assigned_cases.php");
            exit;
        } else {
            // Invalid credentials
            $error_message = "Invalid credentials. Please try again.";
        }
    } else {
        // Invalid credentials
        $error_message = "Invalid credentials. Please try again.";
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
    <title>Police Login</title>
    <link rel="stylesheet" href="css/police_login.css" />
</head>
<body>
    <div class="login-container">
        <img src="images/sondu_logo.png" alt=""/>
        <h1 class="login-header">Police Log In</h1>
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <p>Hello Officer, please log in to continue.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="policeid" placeholder="POLICE ID" required>
            <input type="email" name="policeemail" placeholder="POLICE Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="login-button">Login</button>
        </form>
        <p class="forgot-password">
            <a href="#" onclick="displayMessage()">Forgot Password</a>
        </p>
    </div>

    <script>
        function displayMessage() {
            alert("Kindly contact admin to change the password");
        }
    </script>
</body>
</html>
