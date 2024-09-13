<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Fetch police records from the database
$fetch_query = "SELECT * FROM police";
$result = mysqli_query($conn, $fetch_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/manage_police.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Police Details</h2>
            <table>
                <tr>
                    <th>Police ID</th>
                    <th>Police Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['police_id']; ?></td>
                        <td><?php echo $row['police_email']; ?></td>
                        <td>
                            <?php
                            $current_time = date('Y-m-d H:i:s');
                            if ($current_time >= $row['start_disable'] && $current_time <= $row['end_disable']) {
                                echo "Disabled";
                            } else {
                                echo "Active";
                            }
                            ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="showEndScheduleAlert('<?php echo $row['police_id']; ?>')"><i class="fas fa-clock"></i> End duty</button>
                                <?php if ($current_time >= $row['start_disable'] && $current_time <= $row['end_disable']): ?>
                                    <button onclick="activateUser('<?php echo $row['police_id']; ?>')"><i class="fas fa-check"></i> Activate duty</button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <script>
        function showEndScheduleAlert(policeId) {
            Swal.fire({
                title: 'Set Schedule',
                html: `
                    <h4> Start Date and Time </h4>
                    <input type="datetime-local" id="startDateTime" class="swal2-input" placeholder="Start Date and Time">
                   <h4> End Date and Time </h4>
                    <input type="datetime-local" id="endDateTime" class="swal2-input" placeholder="End Date and Time">
                `,
                confirmButtonText: 'Submit',
                showCancelButton: true,
                preConfirm: () => {
                    const startDateTime = Swal.getPopup().querySelector('#startDateTime').value;
                    const endDateTime = Swal.getPopup().querySelector('#endDateTime').value;
                    const now = new Date().toISOString().slice(0, 16);
                    if (!startDateTime || !endDateTime) {
                        Swal.showValidationMessage(`Please enter both start and end date and time`);
                    } else if (startDateTime >= endDateTime) {
                        Swal.showValidationMessage(`End date must be later than start date`);
                    } else if (startDateTime < now && endDateTime > now) {
                        Swal.showValidationMessage(`End date cannot be in the future if start date is in the past`);
                    } else if (startDateTime === now || endDateTime === now) {
                        Swal.showValidationMessage(`Current date cannot be used for end date`);
                    }
                    return { startDateTime: startDateTime, endDateTime: endDateTime };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { startDateTime, endDateTime } = result.value;
                    $.ajax({
                        url: 'end_schedule.php',
                        method: 'POST',
                        data: {
                            police_id: policeId,
                            start_date: startDateTime,
                            end_date: endDateTime
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Schedule set successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'police_schedule.php';
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error setting schedule',
                                text: xhr.responseText,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }

        function activateUser(policeId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to activate this police officer's account.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, activate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'activate_police.php',
                        method: 'POST',
                        data: {
                            police_id: policeId
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Police activated successfully',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'police_schedule.php';
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error activating police',
                                text: xhr.responseText,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>
