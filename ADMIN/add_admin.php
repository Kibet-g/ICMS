<?php
// Include the database connection
include '../Database/db_con.php';

// Define variables to store form data
$admin_id = $admin_username = $email = $password = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $admin_username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password for security

    // Check for duplicate admin_username
    $check_username_query = "SELECT * FROM admin WHERE admin_username = '$admin_username'";
    $result_username = mysqli_query($conn, $check_username_query);

    // Check for duplicate email
    $check_email_query = "SELECT * FROM admin WHERE email = '$email'";
    $result_email = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result_username) > 0) {
        // Set error message for duplicate admin_username
        $error_message = "Error: Admin username already exists!";
    } elseif (mysqli_num_rows($result_email) > 0) {
        // Set error message for duplicate email
        $error_message = "Error: Email already exists!";
    } else {
        // Insert the admin record into the database
        $insert_query = "INSERT INTO admin (admin_id, admin_username, email, password) VALUES ('$admin_id', '$admin_username', '$email', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            // Set success message
            $success_message = "Admin added successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="css/add_admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="admin_id"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-top: 5px;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            display: block;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'constants/sidebar.php'; ?>

    <?php if (!empty($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $error_message; ?>'
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $success_message; ?>'
            });
        </script>
    <?php endif; ?>

    <div class="main-content">
        <div class="container">
            <h2>Add Admin</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="admin_id">Admin ID:</label>
                    <input type="text" id="admin_id" name="admin_id" required>
                </div>
                <div class="form-group">
                    <label for="admin_username">Admin Username:</label>
                    <input type="text" id="admin_username" name="admin_username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Add Admin</button>
            </form>
        </div>
    </div>
</body>
</html>
