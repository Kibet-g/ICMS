<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Define variables to store form data
$location_name = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $location_name = mysqli_real_escape_string($conn, $_POST['location_name']);

    // Check for duplicate location_name
    $check_location_query = "SELECT * FROM locations WHERE location_name = '$location_name'";
    $result_location = mysqli_query($conn, $check_location_query);

    if (mysqli_num_rows($result_location) > 0) {
        // Set error message for duplicate location_name
        $error_message = "Error: Location already exists!";
    } else {
        // Insert the location record into the database
        $insert_query = "INSERT INTO locations (location_name) VALUES ('$location_name')";
        if (mysqli_query($conn, $insert_query)) {
            // Set success message
            $success_message = "Location added successfully!";
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
    <title>Add Location</title>
    <link rel="stylesheet" href="css/add_location.css">
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
        <label for="location_name">Location Name:</label>
        <input type="text" id="location_name" name="location_name" required><br><br>
        <button type="submit">Add Location</button>
    </form>
</body>
</html>
