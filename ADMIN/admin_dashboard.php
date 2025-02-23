<?php
include '../Database/db_con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include 'constants/sidebar.php'; ?>

    <div class="main-content">
        <div class="container">
            <div class="insights">
                <!-- Logged In Users -->
                <div class="insight" id="users-insight">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="info">
                        <h2 id="users-count">
                            <?php
                            $sql_users = "SELECT COUNT(*) AS count FROM users WHERE logged_in = 1";
                            $result_users = $conn->query($sql_users);

                            if ($result_users && $row = $result_users->fetch_assoc()) {
                                echo $row['count'];
                            } else {
                                echo "0"; // Default to 0 if query fails
                            }
                            ?>
                        </h2>
                        <p>Logged In Users</p>
                    </div>
                </div>

                <!-- Police Officers On Duty -->
                <div class="insight" id="police-insight">
                    <div class="icon"><i class="fas fa-user-shield"></i></div>
                    <div class="info">
                        <h2 id="police-count">
                            <?php
                            $current_time = date('Y-m-d H:i:s');
                            $sql_police = "SELECT COUNT(*) AS count FROM police 
                                           WHERE (start_disable IS NULL OR '$current_time' < start_disable) 
                                           AND (end_disable IS NULL OR '$current_time' > end_disable)";

                            $result_police = $conn->query($sql_police);

                            if ($result_police && $row = $result_police->fetch_assoc()) {
                                echo $row['count'];
                            } else {
                                echo "0"; // Default to 0 if query fails
                            }
                            ?>
                        </h2>
                        <p>Police Officers On Duty</p>
                    </div>
                </div>

                <!-- Reported Cases -->
                <div class="insight" id="cases-insight">
                    <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                    <div class="info">
                        <h2 id="cases-count">
                            <?php
                            $sql_verified = "SELECT COUNT(*) AS count FROM verified";
                            $sql_declined = "SELECT COUNT(*) AS count FROM declined";

                            $result_verified = $conn->query($sql_verified);
                            $result_declined = $conn->query($sql_declined);

                            $verified_cases = ($result_verified && $row = $result_verified->fetch_assoc()) ? $row['count'] : 0;
                            $declined_cases = ($result_declined && $row = $result_declined->fetch_assoc()) ? $row['count'] : 0;

                            echo $verified_cases + $declined_cases;
                            ?>
                        </h2>
                        <p>Reported Cases</p>
                    </div>
                </div>
            </div>

            <!-- Event Logs -->
            <div class="logs">
                <h2>Event Logs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Event</th>
                        </tr>
                    </thead>
                    <tbody id="logs-table-body">
                        <?php
                        $sql_logs = "SELECT timestamp, user, event FROM event_logs ORDER BY timestamp DESC";
                        $result_logs = $conn->query($sql_logs);

                        if ($result_logs && $result_logs->num_rows > 0) {
                            while ($row = $result_logs->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['event']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No logs found</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
```php
<?php
// Include database connection file
include '../Database/db_con.php';

// Function to get logged in users count
function getLoggedInUsersCount($conn) {
    $sql_users = "SELECT COUNT(*) AS count FROM users WHERE logged_in = 1";
    $result_users = $conn->query($sql_users);
    return ($result_users && $row = $result_users->fetch_assoc()) ? $row['count'] : 0;
}

// Function to get police officers on duty count
function getPoliceOnDutyCount($conn) {
    $current_time = date('Y-m-d H:i:s');
    $sql_police = "SELECT COUNT(*) AS count FROM police 
                   WHERE (start_disable IS NULL OR '$current_time' < start_disable) 
                   AND (end_disable IS NULL OR '$current_time' > end_disable)";
    $result_police = $conn->query($sql_police);
    return ($result_police && $row = $result_police->fetch_assoc()) ? $row['count'] : 0;
}

// Function to get reported cases count
function getReportedCasesCount($conn) {
    $sql_verified = "SELECT COUNT(*) AS count FROM verified";
    $sql_declined = "SELECT COUNT(*) AS count FROM declined";
    $result_verified = $conn->query($sql_verified);
    $result_declined = $conn->query($sql_declined);
    $verified_cases = ($result_verified && $row = $result_verified->fetch_assoc()) ? $row['count'] : 0;
    $declined_cases = ($result_declined && $row = $result_declined->fetch_assoc()) ? $row['count'] : 0;
    return $verified_cases + $declined_cases;
}

// Function to get event logs
function getEventLogs($conn) {
    $sql_logs = "SELECT timestamp, user, event FROM event_logs ORDER BY timestamp DESC";
    $result_logs = $conn->query($sql_logs);
    $logs = array();
    if ($result_logs && $result_logs->num_rows > 0) {
        while ($row = $result_logs->fetch_assoc()) {
            $logs[] = array(
                'timestamp' => htmlspecialchars($row['timestamp']),
                'user' => htmlspecialchars($row['user']),
                'event' => htmlspecialchars($row['event'])
            );
        }
    }
    return $logs;
}

// Get counts and logs
$loggedInUsersCount = getLoggedInUsersCount($conn);
$policeOnDutyCount = getPoliceOnDutyCount($conn);
$reportedCasesCount = getReportedCasesCount($conn);
$eventLogs = getEventLogs($conn);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include 'constants/sidebar.php'; ?>
    <div class="main-content">
        <div class="container">
            <div class="insights">
                <!-- Logged In Users -->
                <div class="insight" id="users-insight">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="info">
                        <h2 id="users-count"><?php echo $loggedInUsersCount; ?></h2>
                        <p>Logged In Users</p>
                    </div>
                </div>

                <!-- Police Officers On Duty -->
                <div class="insight" id="police-insight">
                    <div class="icon"><i class="fas fa-user-shield"></i></div>
                    <div class="info">
                        <h2 id="police-count"><?php echo $policeOnDutyCount; ?></h2>
                        <p>Police Officers On Duty</p>
                    </div>
                </div>

                <!-- Reported Cases -->
                <div class="insight" id="cases-insight">
                    <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                    <div class="info">
                        <h2 id="cases-count"><?php echo $reportedCasesCount; ?></h2>
                        <p>Reported Cases</p>
                    </div>
                </div>
            </div>

            <!-- Event Logs -->
            <div class="logs">
                <h2>Event Logs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Event</th>
                        </tr>
                    </thead>
                    <tbody id="logs-table-body">
                        <?php if (!empty($eventLogs)) { ?>
                            <?php foreach ($eventLogs as $log) { ?>
                                <tr>
                                    <td><?php echo $log['timestamp']; ?></td>
                                    <td><?php echo $log['user']; ?></td>
                                    <td><?php echo $log['event']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr><td colspan='3'>No logs found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
```