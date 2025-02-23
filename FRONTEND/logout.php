<?php
include '../Database/db_con.php';

session_start();
// Get the email of the logged-in user
$email = $_SESSION['email'];

// Destroy session
session_unset();
session_destroy();

// Update the logged_in column for the user to indicate logout
$update_logged_out_query = "UPDATE users SET logged_in = 0 WHERE email = '$email'";
mysqli_query($conn, $update_logged_out_query);

header('location:login.php');
?>
