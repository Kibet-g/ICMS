<?php
// Include the database connection
include '../Database/db_con.php';

// Check if id_number is set
if (isset($_POST['id_number'])) {
    // Get the id_number from the POST data
    $id_number = $_POST['id_number'];

    // Prepare the delete query
    $delete_query = "DELETE FROM users WHERE id_number = ?";

    // Initialize a statement
    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind the id_number to the statement
        mysqli_stmt_bind_param($stmt, "i", $id_number);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the page where you list the user records
            header("Location: manage_users.php?message=User record deleted successfully");
            exit();
        } else {
            // Redirect with an error message if execution failed
            header("Location: manage_users.php?error=Failed to delete user record");
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
    // Redirect with an error message if id_number is not set
    header("Location: manage_users.php?error=ID number not provided");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
