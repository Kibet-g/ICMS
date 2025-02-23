<?php
// Start the session
session_start();

// Include the database connection
include '../Database/db_con.php';

// Get the police ID of the logged-in police officer
$police_id = $_SESSION['police_id'];

// Destroy session
session_unset();
session_destroy();

// Update the logged_in column for the police officer to indicate logout
$update_logged_out_query = "UPDATE police SET logged_in = 0 WHERE police_id = '$police_id'";
mysqli_query($conn, $update_logged_out_query);

// Redirect to login page
header('location:police_login.php');
?>
