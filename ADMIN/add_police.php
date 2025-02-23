<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Define variables to store form data
$police_id = $police_email = $password = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $police_id = mysqli_real_escape_string($conn, $_POST['police_id']);
    $police_email = mysqli_real_escape_string($conn, $_POST['police_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check for duplicate police_id
    $check_id_query = "SELECT * FROM police WHERE police_id = '$police_id'";
    $result_id = mysqli_query($conn, $check_id_query);

    // Check for duplicate police_email
    $check_email_query = "SELECT * FROM police WHERE police_email = '$police_email'";
    $result_email = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result_id) > 0) {
        // Set error message for duplicate police_id
        $error_message = "Error: Police ID already exists!";
    } elseif (mysqli_num_rows($result_email) > 0) {
        // Set error message for duplicate police_email
        $error_message = "Error: Police Email already exists!";
    } else {
        // Insert the police record into the database
        $insert_query = "INSERT INTO police (police_id, police_email, password) VALUES ('$police_id', '$police_email', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            // Set success message
            $success_message = "Police officer added successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
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
    <link rel="stylesheet" href="css/add_police.css">
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
