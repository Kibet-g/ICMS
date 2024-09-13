<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['police_id'])) {
    // Redirect the user to the login page
    header("Location: police_login.php");
    exit(); // Stop further execution
}
?>