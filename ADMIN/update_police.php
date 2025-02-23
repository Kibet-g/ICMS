<?php
// Include the database connection
include '../Database/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $police_id = $_POST['police_id'];
    $police_email = $_POST['police_email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the police details in the database
    $update_query = "UPDATE police SET police_email = ?, password = ? WHERE police_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssi', $police_email, $hashed_password, $police_id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the police details page
    header("Location: manage_police.php");
    exit();
}
?>
