<?php
// Include the database connection
include '../Database/db_con.php';

// Get the ID number from the URL
$id_number = isset($_GET['id_number']) ? mysqli_real_escape_string($conn, $_GET['id_number']) : '';

// Retrieve case details before declining
$select_query = "SELECT * FROM cases WHERE id_number = '$id_number'";
$result = mysqli_query($conn, $select_query);

// Check if the case exists
if (mysqli_num_rows($result) > 0) {
    // Fetch case details
    $case_details = mysqli_fetch_assoc($result);

    // Insert the case details into the 'declined' table
    $insert_query = "INSERT INTO declined (name, id_number, mobile_no, location, occurence_date, occurence_time, description, id_upload, email, status) 
                     VALUES ('{$case_details['name']}', '{$case_details['id_number']}', '{$case_details['mobile_no']}', '{$case_details['location']}', 
                             '{$case_details['occurence_date']}', '{$case_details['occurence_time']}', '{$case_details['description']}', 
                             '{$case_details['id_upload']}', '{$case_details['email']}', 'Declined')";

    if (mysqli_query($conn, $insert_query)) {
        // Delete the case from the 'cases' table
        $delete_query = "DELETE FROM cases WHERE id_number = '$id_number'";
        if (mysqli_query($conn, $delete_query)) {
            // If the deletion is successful, redirect to `assigned_case.php`
            header("Location: assigned_cases.php");
            exit;
        } else {
            echo "Error deleting case: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting case into 'declined' table: " . mysqli_error($conn);
    }
} else {
    echo "Case not found.";
}

// Close the database connection
mysqli_close($conn);
?>
