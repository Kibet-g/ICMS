<?php
include '../Database/db_con.php';

function log_event($user, $event) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO event_logs (user, event) VALUES (?, ?)");
    if ($stmt === false) {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("ss", $user, $event);
    if ($bind === false) {
        die('bind_param() failed: ' . htmlspecialchars($stmt->error));
    }

    $exec = $stmt->execute();
    if ($exec === false) {
        die('execute() failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}

// Example usage
log_event('admin', 'User logged in');

// Close the database connection
$conn->close();
?>
