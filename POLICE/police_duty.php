<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar_header.php';

// Fetch police records that are currently on duty from the database
$current_time = date('Y-m-d H:i:s');
$fetch_query = "SELECT * FROM police WHERE ('$current_time' < start_disable OR '$current_time' > end_disable) OR (start_disable IS NULL OR end_disable IS NULL)";
$result = mysqli_query($conn, $fetch_query);

// Check for query errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container {
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            text-align: center;
        }
        .action-buttons button {
            padding: 5px 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .action-buttons button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Police Details</h2>
            <table>
                <tr>
                    <th>Police ID</th>
                    <th>Police Email</th>
                    <th>Status</th>
                </tr>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)): 
                ?>
                    <tr>
                        <td><?php echo $row['police_id']; ?></td>
                        <td><?php echo $row['police_email']; ?></td>
                        <td>Active on Duty</td>
                    </tr>
                <?php 
                    endwhile; 
                } else {
                    echo "<tr><td colspan='3'>No police officers are currently on duty.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>
