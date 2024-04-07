<?php
session_start(); // Start session to store user data

// Include database connection file
include '../Database/db_con.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // user input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    // Hash the password for secure comparison
    $hashed_password = hash('sha256', $password); // Example hashing method
    
    // Query to check if the user exists in the database
    $query = "SELECT * FROM icms_database.users WHERE email = '$email' AND password = '$hashed_password'";
    $result = mysqli_query($conn, $query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        // Error in query or user not found
        $_SESSION['error'] = "Invalid email or password. Please try again.";
        header("Location: login.php");
        exit(); // Stop script execution
    } else {
        // User exists, set session variables and redirect to home.php
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['name']; // Assuming 'name' is the username
        header("Location: home.php");
        exit(); // Stop script execution after redirect
    }
} else {
    // If the form is not submitted, redirect back to the login page
    header("Location: login.php");
    exit(); // Stop script execution after redirect
}
?>
