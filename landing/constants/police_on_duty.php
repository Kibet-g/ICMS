<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police On Duty</title>
    <style>
        /* Styling for the police on duty section */
        .police-on-duty {
            margin-top: 20px;
            text-align: center;
        }
        .police-on-duty h2 {
            margin-bottom: 20px;
        }
        .scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .police-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: left;
            flex: 0 0 auto;
            width: 200px; /* Fixed width to control the size of each card */
        }
        .police-card h3 {
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 1.2em;
        }
        .police-card p {
            margin: 0;
            color: #555;
        }
    </style>
</head>
<body>
    <?php
    // Include the database connection
    $db_con_path = __DIR__ . '/../../Database/db_con.php';

    if (file_exists($db_con_path)) {
        include $db_con_path;

        // Fetch police records that are currently on duty
        $current_time = date('Y-m-d H:i:s');
        $query = "SELECT * FROM police WHERE ('$current_time' < start_disable OR '$current_time' > end_disable) OR (start_disable IS NULL OR end_disable IS NULL)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="police-on-duty">';
                
                echo '<div class="scroll-container">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="police-card">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>Phone: ' . htmlspecialchars($row['phone_number']) . '</p>';
                    echo '<p>Status: Active on Duty</p>';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            } else {
                echo '<p>No police officers are currently on duty.</p>';
            }
        } else {
            echo '<p>Error: ' . mysqli_error($conn) . '</p>';
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo '<p>Error: Could not load the database connection file.</p>';
    }
    ?>
</body>
</html>
