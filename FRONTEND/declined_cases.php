<?php
// Start the session
include './constants/authenticator.php';
include './constants/sidebar_header.php';

// Include the database connection file
include '../Database/db_con.php';

// Check if the user is logged in (i.e., if their session is set)
if (isset($_SESSION['email'])) {
    // Fetch user details from the database using the session email
    $email = $_SESSION['email'];
    
    // Properly quote the email address in the SQL query
    $sql = "SELECT * FROM declined WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/track_case.css">
            <title>User Case Details</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        </head>
        <body>
            <div class="container">
                <div class="form-container">
                    <h2>User Case Details</h2>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>ID Number</th>
                            <th>Case Number</th>
                            <th>Mobile Number</th>
                            <th>Location</th>
                            <th>Occurrence Date</th>
                            <th>Occurrence Time</th>
                            <th>ID Upload</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["id_number"]; ?></td>
                                <td><?php echo $row["case_number"]; ?></td>
                                <td><?php echo $row["mobile_no"]; ?></td>
                                <td><?php echo $row["location"]; ?></td>
                                <td><?php echo $row["occurence_date"]; ?></td>
                                <td><?php echo $row["occurence_time"]; ?></td>
                                <td><a href="../FRONTEND/<?php echo htmlspecialchars($row['id_upload']); ?>" target="_blank">
                                    <img src="../FRONTEND/<?php echo htmlspecialchars($row['id_upload']); ?>" alt="ID Upload">
                                </a></td>
                                <td><?php echo $row["description"]; ?></td>
                                <td><a href="#" class="status-button" data-case-number="<?php echo $row["case_number"]; ?>" style="display: inline-block; padding: 8px 16px; background-color: #FF5733; color: white; text-align: center; text-decoration: none; border: none; border-radius: 4px; cursor: pointer;"><?php echo $row["status"]; ?></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('.status-button').click(function(e) {
                        e.preventDefault();

                        var caseNumber = $(this).data('case-number');

                        // Fetch case details using AJAX
                        $.ajax({
                            url: 'fetch_case_details.php',
                            type: 'POST',
                            data: {case_number: caseNumber},
                            success: function(response) {
                                var caseData = JSON.parse(response);

                                Swal.fire({
                                    title: 'Edit Case Details',
                                    html:
                                        '<form id="edit-case-form" enctype="multipart/form-data" style="text-align: left;">' +
                                        '<div id="case-details-form">' +
                                        '<input type="hidden" name="case_number" value="' + caseData.case_number + '">' +
                                        '<input type="hidden" name="email" value="' + caseData.email + '">' +
                                        '<label>Name: </label><input type="text" name="name" value="' + caseData.name + '" readonly><br>' +
                                        '<label>ID Number: </label><input type="text" name="id_number" value="' + caseData.id_number + '" readonly><br>' +
                                        '<label>Mobile Number: </label><input type="text" name="mobile_no" value="' + caseData.mobile_no + '" readonly><br>' +
                                        '<label>Location: </label><input type="text" name="location" value="' + caseData.location + '" readonly><br>' +
                                        '<label>Occurrence Date: </label><input type="date" name="occurence_date" value="' + caseData.occurence_date + '" readonly><br>' +
                                        '<label>Occurrence Time: </label><input type="time" name="occurence_time" value="' + caseData.occurence_time + '" readonly><br>' +
                                        '<label>ID Upload: </label><input type="file" name="id_upload"><br>' +
                                        '<label>Description: </label><textarea name="description">' + caseData.description + '</textarea><br>' +
                                        '</div>' +
                                        '</form>',
                                    showCancelButton: true,
                                    confirmButtonText: 'Save',
                                    preConfirm: () => {
                                        var formData = new FormData(document.getElementById('edit-case-form'));

                                        return $.ajax({
                                            url: 'update_case_details.php',
                                            type: 'POST',
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(response) {
                                                return response;
                                            }
                                        });
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire('Saved!', 'Your changes have been saved.', 'success');
                                    }
                                });
                            }
                        });
                    });
                });
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "No reported cases found";
    }
} else {
    // If the user is not logged in, redirect them to the login page or display a message
    // For example:
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

$conn->close();
?>
