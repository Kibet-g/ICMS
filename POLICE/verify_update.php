<?php
// Include the database connection
include '../Database/db_con.php';

function generateUniqueObNumber($conn, $userId) {
    // Attempt limit to prevent infinite loops
    $attempts = 0;
    $max_attempts = 100;

    do {
        if ($attempts >= $max_attempts) {
            error_log("Error generating unique ob_number: Exceeded maximum attempts");
            exit("Error generating unique ob_number: Exceeded maximum attempts");
        }

        // Generate a timestamp to ensure uniqueness
        $timestamp = time();
        // Generate a unique identifier for the user
        $user_id_hash = sha1($userId); // Example: You might hash the user ID for uniqueness
        // Combine timestamp and user identifier
        $ob_number = strtoupper(substr(base_convert($timestamp, 10, 36), 0, 4)) . strtoupper(substr($user_id_hash, 0, 4));

        // Check if this ob_number already exists in the database
        $check_query = "SELECT COUNT(*) as count FROM verified WHERE ob_number = '$ob_number'";
        $check_result = mysqli_query($conn, $check_query);

        if (!$check_result) {
            error_log("Error checking ob_number: " . mysqli_error($conn));
            exit("Error checking ob_number");
        }

        $row = mysqli_fetch_assoc($check_result);
        $attempts++;
    } while ($row['count'] > 0);

    return $ob_number;
}

// Get the ID number from the URL
$id_number = isset($_GET['id_number']) ? mysqli_real_escape_string($conn, $_GET['id_number']) : '';

if ($id_number === '') {
    exit("ID number is required.");
}

// Start a transaction
mysqli_begin_transaction($conn);

try {
    // Retrieve case details before deleting
    $select_query = "SELECT * FROM cases WHERE id_number = '$id_number'";
    $result = mysqli_query($conn, $select_query);

    if (!$result) {
        throw new Exception("Error selecting case: " . mysqli_error($conn));
    }

    // Check if the case exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch case details
        $case_details = mysqli_fetch_assoc($result);

        // Generate a unique ob_number
        $ob_number = generateUniqueObNumber($conn, $case_details['id_number']);

        // Insert the case details into the 'verified' table with the unique ob_number
        $insert_query = "INSERT INTO verified (ob_number, name, id_number, mobile_no, location, occurence_date, occurence_time, description, id_upload, email, status) 
                         VALUES ('$ob_number', '{$case_details['name']}', '{$case_details['id_number']}', '{$case_details['mobile_no']}', '{$case_details['location']}', 
                                 '{$case_details['occurence_date']}', '{$case_details['occurence_time']}', '{$case_details['description']}', 
                                 '{$case_details['id_upload']}', '{$case_details['email']}', 'verified')";

        if (!mysqli_query($conn, $insert_query)) {
            throw new Exception("Error inserting case into 'verified' table: " . mysqli_error($conn));
        }

        // Delete the case from the 'cases' table
        $delete_query = "DELETE FROM cases WHERE id_number = '$id_number'";
        if (!mysqli_query($conn, $delete_query)) {
            throw new Exception("Error deleting case: " . mysqli_error($conn));
        }

        // Commit the transaction
        mysqli_commit($conn);

        // Redirect to `assigned_cases.php`
        header("Location: assigned_cases.php");
        exit;
    } else {
        throw new Exception("Case not found.");
    }
} catch (Exception $e) {
    // Rollback the transaction on error
    mysqli_rollback($conn);
    error_log($e->getMessage());
    exit($e->getMessage());
}

// Close the database connection
mysqli_close($conn);
?>
