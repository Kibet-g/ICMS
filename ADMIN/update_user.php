<?php
// Include the database connection
include '../Database/db_con.php';

// Check if form fields are set and not empty
if (isset($_POST['id_number'], $_POST['name'], $_POST['email'], $_POST['idtype'], $_POST['mobile_no'], $_POST['password'])) {
    // Get form data
    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $idtype = $_POST['idtype'];
    $mobile_no = $_POST['mobile_no'];
    $password = $_POST['password'];

    // Prepare update query
    $update_query = "UPDATE users SET name=?, email=?, idtype=?, mobile_no=?, password=? WHERE id_number=?";

    // Initialize a statement
    if ($stmt = mysqli_prepare($conn, $update_query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $idtype, $mobile_no, $password, $id_number);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the page where you list the user records
            header("Location: manage_users.php?message=User record updated successfully");
            exit();
        } else {
            // Redirect with an error message if execution failed
            header("Location: manage_users.php?error=Failed to update user record");
            exit();
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Redirect with an error message if preparation failed
        header("Location: manage_users.php?error=Failed to prepare statement");
        exit();
    }
} else {
    // Redirect with an error message if form fields are not set or empty
    header("Location: manage_users.php?error=All fields are required");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
