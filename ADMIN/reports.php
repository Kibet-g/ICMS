<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .charts {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .chart-container {
            flex: 1 1 45%;
            min-width: 300px;
            max-width: 600px;
        }
        .download-button {
            margin: 20px;
            text-align: center;
        }
        .download-button a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php include 'constants/sidebar.php'; ?>

    <div class="main-content">
        <div class="container">
            <h2>Data Analysis</h2>
            <div class="download-button">
                <a href="download_reports.php">Download Report</a>
            </div>
            <div class="charts">
                <div class="chart-container">
                    <canvas id="casesVsPoliceChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="logsVsUsersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../Database/db_con.php';

    // Fetch logged in users count
    $sql_users = "SELECT COUNT(*) AS count FROM users WHERE logged_in = 1";
    $result_users = $conn->query($sql_users);
    $logged_in_users = ($result_users->num_rows > 0) ? $result_users->fetch_assoc()['count'] : 0;

    // Fetch police officers on duty count
    $current_time = date('Y-m-d H:i:s');
    $sql_police = "SELECT COUNT(*) AS count FROM police 
                   WHERE (start_disable IS NULL OR '$current_time' < start_disable) 
                   AND (end_disable IS NULL OR '$current_time' > end_disable)";
    $result_police = $conn->query($sql_police);
    $active_police = ($result_police->num_rows > 0) ? $result_police->fetch_assoc()['count'] : 0;

    // Fetch total reported cases count
    $sql_verified = "SELECT COUNT(*) AS count FROM verified";
    $result_verified = $conn->query($sql_verified);
    $verified_cases = ($result_verified->num_rows > 0) ? $result_verified->fetch_assoc()['count'] : 0;

    $sql_declined = "SELECT COUNT(*) AS count FROM declined";
    $result_declined = $conn->query($sql_declined);
    $declined_cases = ($result_declined->num_rows > 0) ? $result_declined->fetch_assoc()['count'] : 0;

    $total_cases = $verified_cases + $declined_cases;

    // Fetch event logs count
    $sql_logs = "SELECT COUNT(*) AS count FROM event_logs";
    $result_logs = $conn->query($sql_logs);
    $total_logs = ($result_logs->num_rows > 0) ? $result_logs->fetch_assoc()['count'] : 0;

    $conn->close();
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctxCasesVsPolice = document.getElementById('casesVsPoliceChart').getContext('2d');
            const ctxLogsVsUsers = document.getElementById('logsVsUsersChart').getContext('2d');

            const policeCount = <?php echo $active_police; ?>;
            const casesCount = <?php echo $total_cases; ?>;
            const logsCount = <?php echo $total_logs; ?>;
            const usersCount = <?php echo $logged_in_users; ?>;

            const casesVsPoliceChart = new Chart(ctxCasesVsPolice, {
                type: 'bar',
                data: {
                    labels: ['Reported Cases', 'Police Officers On Duty'],
                    datasets: [{
                        label: 'Count',
                        data: [casesCount, policeCount],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const logsVsUsersChart = new Chart(ctxLogsVsUsers, {
                type: 'bar',
                data: {
                    labels: ['Event Logs', 'Logged In Users'],
                    datasets: [{
                        label: 'Count',
                        data: [logsCount, usersCount],
                        backgroundColor: [
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(54, 162, 235, 0.2)'
                        ],
                        borderColor: [
                            'rgba(153, 102, 255, 1)',
                            'rgba(54, 162, 235, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
