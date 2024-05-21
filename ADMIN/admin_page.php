<?php
// Include the database connection
include '../Database/db_con.php';

// Define variables to store form data
$police_id = $police_email = $password = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $police_id = mysqli_real_escape_string($conn, $_POST['police_id']);
    $police_email = mysqli_real_escape_string($conn, $_POST['police_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Insert the police record into the database
    $insert_query = "INSERT INTO police (police_id, police_email, password) VALUES ('$police_id', '$police_email', '$password')";
    if (mysqli_query($conn, $insert_query)) {
        // Redirect to a success page or display a success message
        header("Location: success.php");
        exit;
    } else {
        $error_message = "Error: " . mysqli_error($conn);
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
    <title>Add Police</title>
</head>
<body>
    <h2>Add Police</h2>
    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="police_id">Police ID:</label>
        <input type="text" id="police_id" name="police_id" required><br><br>
        <label for="police_email">Police Email:</label>
        <input type="email" id="police_email" name="police_email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Add Police</button>
    </form>
</body>
</html>
