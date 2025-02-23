<?php
// Include the database connection
include '../Database/db_con.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $police_id = $_POST['police_id'];

    // Update the police record to clear the disable period
    $update_query = "UPDATE police SET start_disable = NULL, end_disable = NULL WHERE police_id = '$police_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Account Activated',
                text: 'The account for the police officer has been successfully activated.',
            }).then(() => {
                window.location.href = 'police_details.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to activate the account for the police officer.',
            }).then(() => {
                window.location.href = 'police_details.php';
            });
        </script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
