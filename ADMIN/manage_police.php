<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Fetch police records from the database
$fetch_query = "SELECT * FROM police";
$result = mysqli_query($conn, $fetch_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/manage_police.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Police Details</h2>
            <table>
                <tr>
                    <th>Police ID</th>
                    <th>Police Email</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['police_id']; ?></td>
                        <td><?php echo $row['police_email']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="confirmUpdate('<?php echo $row['police_id']; ?>', '<?php echo $row['police_email']; ?>')"><i class="fas fa-pen"></i> Update</button>
                                <form id="deleteForm_<?php echo $row['police_id']; ?>" action="delete_police.php" method="post" onsubmit="return showDeleteAlert(event, '<?php echo $row['police_id']; ?>');">
                                    <input type="hidden" name="police_id" value="<?php echo $row['police_id']; ?>">
                                    <button type="submit" class="delete"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <div id="updateFormContainer" class="swal-like">
        <div class="swal-like-content">
            <form id="updateForm" action="update_police.php" method="post">
                <input type="hidden" name="police_id" id="updatePoliceId">
                <label for="police_email">Police Email:</label>
                <input type="email" name="police_email" id="updatePoliceEmail" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="updatePassword" required>
                <button type="submit">Update</button>
                <button type="button" onclick="closeUpdateForm()">Cancel</button>
            </form>
        </div>
    </div>
    <script src="Javascript/sweetalert.js"></script>

   <link rel="stylesheet" href="css/sweetalert.css">

<?php
// Close the database connection
mysqli_close($conn);
?>
</body>
</html>
