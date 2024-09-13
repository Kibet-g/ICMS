<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';

// Fetch police records from the database
$fetch_query = "SELECT police_id, name, police_email FROM police";
$result = mysqli_query($conn, $fetch_query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Details</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/manage_police.css">
</head>
<body>
    <div class="container">
        <h2>Police Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Police ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['police_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['police_email']; ?></td>
                        <td class="action-buttons">
                            <button class="update-btn" onclick="confirmUpdate('<?php echo $row['police_id']; ?>', '<?php echo $row['police_email']; ?>')">Update</button>
                            <form id="deleteForm_<?php echo $row['police_id']; ?>" action="delete_police.php" method="post" onsubmit="return showDeleteAlert(event, '<?php echo $row['police_id']; ?>');">
                                <input type="hidden" name="police_id" value="<?php echo $row['police_id']; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="Javascript/sweetalert.js"></script>
    <link rel="stylesheet" href="css/sweetalert.css">

    <script>
        function confirmUpdate(policeId, policeEmail) {
            Swal.fire({
                title: 'Update Confirmation',
                text: "Do you want to update the details?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    showUpdateForm(policeId, policeEmail);
                }
            });
        }

        function showUpdateForm(policeId, policeEmail) {
            Swal.fire({
                title: 'Update Details',
                html:
                '<input type="hidden" id="updatePoliceId" value="'+policeId+'">' +
                '<label for="police_email">Police Email:</label>' +
                '<input type="email" id="updatePoliceEmail" class="swal2-input" value="'+policeEmail+'">',
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const policeId = Swal.getPopup().querySelector('#updatePoliceId').value
                    const policeEmail = Swal.getPopup().querySelector('#updatePoliceEmail').value
                    return { policeId: policeId, policeEmail: policeEmail }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send the data to update_police.php
                    const policeId = result.value.policeId;
                    const policeEmail = result.value.policeEmail;

                    // Perform AJAX request to update_police.php
                    fetch('update_police.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'police_id': policeId,
                            'police_email': policeEmail
                        })
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Handle the response from update_police.php
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Details updated successfully!'
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error updating details.'
                        });
                    });
                }
            });
        }

        function showDeleteAlert(event, policeId) {
            event.preventDefault(); // Prevent the form from submitting immediately

            Swal.fire({
                title: 'Delete Confirmation',
                text: "Are you sure you want to delete this record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm_' + policeId).submit();
                }
            });

            return false; // Prevent the form from submitting the traditional way
        }
    </script>
</body>
</html>
