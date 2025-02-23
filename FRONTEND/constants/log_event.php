<?php
include '../Database/db_con.php';

function log_event($user, $event) {
    global $conn;
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO event_logs (user, event) VALUES (?, ?)");
    if ($stmt === false) {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $bind = $stmt->bind_param("ss", $user, $event);
    if ($bind === false) {
        die('bind_param() failed: ' . htmlspecialchars($stmt->error));
    }

    // Execute the statement
    $exec = $stmt->execute();
    if ($exec === false) {
        die('execute() failed: ' . htmlspecialchars($stmt->error));
    }

    // Close the statement
    $stmt->close();
}
?>
