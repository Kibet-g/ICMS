<?php
session_start(); // Start or resume session

// Function to check if user is logged in
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if user is not logged in
        header("Location: login.php");
        exit(); // Stop further execution
    }
}

// Function to set session variables after successful login
function set_session($user_id) {
    $_SESSION['user_id'] = $user_id;
    // You can set other session variables as needed
}

// Function to destroy session and log out user
function logout() {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    // Redirect to login page after logout
    header("Location: login.php");
    exit(); // Stop further execution
}
?>
