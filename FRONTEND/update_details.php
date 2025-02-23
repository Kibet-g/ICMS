<?php
// Start the session
session_start();

// Include the database connection file
include '../Database/db_con.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If the user is not logged in, return an error response
    http_response_code(401);
    echo "Unauthorized";
    exit();
}

// Get the current email from the session
$current_email = $_SESSION['email'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted data and escape it to prevent SQL injection
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile_no = mysqli_real_escape_string($conn, $_POST['mobile_no']);

    // Validate email format
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format";
        exit();
    }

    // Update the user details in the database
    $update_query = "UPDATE users SET email = '$new_email', mobile_no = '$mobile_no' WHERE email = '$current_email'";

    if (mysqli_query($conn, $update_query)) {
        // If the update is successful, update the session email
        $_SESSION['email'] = $new_email;
        echo "Details updated successfully.";
    } else {
        http_response_code(500);
        echo "Error updating details: " . mysqli_error($conn);
    }
} else {
    http_response_code(405);
    echo "Method not allowed";
}

// Close the database connection
mysqli_close($conn);
?>
