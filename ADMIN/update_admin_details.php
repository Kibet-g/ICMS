<?php
include '../Database/db_con.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $admin_username = $_POST['admin_username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Prepare an update statement
    $sql = "UPDATE admin SET admin_username = ?, email = ?, password = ? WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $admin_username, $email, $password, $admin_id);

    if ($stmt->execute()) {
        echo '<div class="success-message">Admin details updated successfully.</div>';
    } else {
        echo '<div class="error-message">Error updating record: ' . $conn->error . '</div>';
    }

    $stmt->close();
}

// Fetch the admin details
$sql = "SELECT admin_id, admin_username, email FROM admin LIMIT 1"; // Assuming only one admin record
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admin_id = $row['admin_id'];
    $admin_username = $row['admin_username'];
    $email = $row['email'];
} else {
    echo '<div class="error-message">No admin found.</div>';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Details</title>
    <link rel="stylesheet" href="css/update_admin_details.css">
  
</head>
<body>
    <?php include 'constants/sidebar.php'; ?>

    <div class="main-content">
        <div class="container">
            <h2>Update Admin Details</h2>
            <form action="update_admin.php" method="post">
                <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                <div class="form-group">
                    <label for="admin_username">Username:</label>
                    <input type="text" id="admin_username" name="admin_username" value="<?php echo htmlspecialchars($admin_username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Admin-Id</label>
                    <input type="admin_id" id="admin_id" name="email" value="<?php echo htmlspecialchars($admin_id); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
