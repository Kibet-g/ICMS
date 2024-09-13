<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include 'constants/sidebar.php'; ?>
  
    <div class="main-content">
        <div class="container">
            <div class="insights">
                <div class="insight" id="users-insight">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="info">
                        <h2 id="users-count">
                            <?php
                            include '../Database/db_con.php';
                            $sql_users = "SELECT COUNT(*) AS count FROM users WHERE logged_in = 1";
                            $result_users = $conn->query($sql_users);
                            $logged_in_users = 0;
                            
                            if ($result_users->num_rows > 0) {
                                $row = $result_users->fetch_assoc();
                                $logged_in_users = $row['count'];
                            }
                            
                            echo $logged_in_users;
                            ?>
                        </h2>
                        <p>Logged In Users</p>
                    </div>
                </div>
                <div class="insight" id="police-insight">
    <div class="icon"><i class="fas fa-user-shield"></i></div>
    <div class="info">
        <h2 id="police-count">
            <?php
            include '../Database/db_con.php';
            $current_time = date('Y-m-d H:i:s');

            // Adjust the query to count police officers on duty
            $sql_police = "SELECT COUNT(*) AS count FROM police 
                           WHERE (start_disable IS NULL OR '$current_time' < start_disable) 
                           AND (end_disable IS NULL OR '$current_time' > end_disable)";
                           
            $result_police = $conn->query($sql_police);
            $active_police = 0;
            
            if ($result_police->num_rows > 0) {
                $row = $result_police->fetch_assoc();
                $active_police = $row['count'];
            }
            
            echo $active_police;
            ?>
        </h2>
        <p>Police Officers On Duty</p>
    </div>
</div>

<div class="insight" id="cases-insight">
    <div class="icon"><i class="fas fa-clipboard-list"></i></div>
    <div class="info">
        <h2 id="cases-count">
            <?php
            include '../Database/db_con.php';

            // Query to count total cases from verified and declined tables
            $sql_verified = "SELECT COUNT(*) AS count FROM verified";
            $result_verified = $conn->query($sql_verified);
            $verified_cases = 0;

            if ($result_verified->num_rows > 0) {
                $row = $result_verified->fetch_assoc();
                $verified_cases = $row['count'];
            }

            $sql_declined = "SELECT COUNT(*) AS count FROM declined";
            $result_declined = $conn->query($sql_declined);
            $declined_cases = 0;

            if ($result_declined->num_rows > 0) {
                $row = $result_declined->fetch_assoc();
                $declined_cases = $row['count'];
            }

            // Calculate total reported cases
            $total_cases = $verified_cases + $declined_cases;

            echo $total_cases;
            ?>
        </h2>
        <p>Reported Cases</p>
    </div>
</div>
            </div>
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

                        if ($result_logs->num_rows > 0) {
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
