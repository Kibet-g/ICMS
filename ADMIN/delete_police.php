<?php
// Include the database connection
include '../Database/db_con.php';

// Check if police_id is set
if (isset($_POST['police_id'])) {
    // Get the police_id from the POST data
    $police_id = $_POST['police_id'];

    // Prepare the delete query
    $delete_query = "DELETE FROM police WHERE police_id = ?";

    // Initialize a statement
    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind the police_id to the statement
        mysqli_stmt_bind_param($stmt, "i", $police_id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the page where you list the police records
            header("Location: manage_police.php?message=Police record deleted successfully");
            exit();
        } else {
            // Redirect with an error message if execution failed
            header("Location: manage_police.php?error=Failed to delete police record");
            exit();
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Redirect with an error message if preparation failed
        header("Location: manage_police.php?error=Failed to prepare statement");
        exit();
    }
} else {
    // Redirect with an error message if police_id is not set
    header("Location: manage_police.php?error=Invalid police ID");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
