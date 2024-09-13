<?php
// Include the database connection
include '../Database/db_con.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['end_date'])) {
    $police_id = $_POST['police_id'];
    $end_date = $_POST['end_date'];
    $start_date = date('Y-m-d H:i:s'); // The start time is the current time

    // Update the police record to set the start and end schedule dates
    $update_query = "UPDATE police SET start_disable = '$start_date', end_disable = '$end_date' WHERE police_id = '$police_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Schedule Ended',
                text: 'The schedule for the police officer has been successfully ended.',
            }).then(() => {
                window.location.href = 'police_details.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to end the schedule for the police officer.',
            }).then(() => {
                window.location.href = 'police_details.php';
            });
        </script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
