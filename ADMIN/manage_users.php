<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Fetch user records from the database
$fetch_query = "SELECT * FROM users";
$result = mysqli_query($conn, $fetch_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/manage_users.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>User Details</h2>
            <table>
                <tr>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>ID Type</th>
                    <th>Mobile No</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id_number']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['idtype']; ?></td>
                        <td><?php echo $row['mobile_no']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="confirmUpdate('<?php echo $row['id_number']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['idtype']; ?>', '<?php echo $row['mobile_no']; ?>')"><i class="fas fa-pen"></i> Update</button>
                                <form id="deleteForm_<?php echo $row['id_number']; ?>" action="delete_user.php" method="post" onsubmit="return confirmDelete(event, '<?php echo $row['id_number']; ?>');">
                                    <input type="hidden" name="id_number" value="<?php echo $row['id_number']; ?>">
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
            <form id="updateForm" action="update_user.php" method="post">
                <input type="hidden" name="id_number" id="updateIdNumber">
                <label for="name">Name:</label>
                <input type="text" name="name" id="updateName" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="updateEmail" required>
                <label for="idtype">ID Type:</label>
                <input type="text" name="idtype" id="updateIdType" required>
                <label for="mobile_no">Mobile No:</label>
                <input type="text" name="mobile_no" id="updateMobileNo" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="updatePassword" required>
                <button type="submit">Update</button>
                <button type="button" onclick="closeUpdateForm()">Cancel</button>
            </form>
        </div>
    </div>

    <div id="deleteFormContainer" class="swal-like">
        <div class="swal-like-content">
            <form id="deleteForm" action="delete_user.php" method="post">
                <input type="hidden" name="id_number" id="deleteIdNumber">
                <p>Are you sure you want to delete this record?</p>
                <button type="submit">Yes, delete it!</button>
                <button type="button" onclick="closeDeleteForm()">Cancel</button>
            </form>
        </div>
    </div>

    
    <script src="Javascript/sweetalertuser.js"></script>
   <link rel="stylesheet" href="css/sweetalertuser.css">
<?php
// Close the database connection
mysqli_close($conn);
?>
</body>
</html>
