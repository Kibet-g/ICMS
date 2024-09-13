<?php
include '../Database/db_con.php';

header('Content-Type: application/json');

$sql = "SELECT timestamp, user, event FROM event_logs ORDER BY timestamp DESC";
$result = $conn->query($sql);

$logs = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

echo json_encode($logs);

$conn->close();
?>
