<?php
// Include the database connection
include '../Database/db_con.php';

// Retrieve the id_number from the URL parameter
$id_number = isset($_GET['id_number']) ? mysqli_real_escape_string($conn, $_GET['id_number']) : '';

// Query to retrieve data from the `cases` table using the id_number
$query = "SELECT * FROM cases WHERE id_number = '$id_number'";
$result = mysqli_query($conn, $query);

// Start HTML output
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<title>Verify Case</title>';
// Link to SweetAlert2 and your custom CSS file
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">';
echo '<link rel="stylesheet" href="css/verify_case.css">';
echo '</head>';
echo '<body>';

echo '<div class="verify-case-container">';
echo '<h2>Verify Case</h2>';

// Check if data is available
if ($row = mysqli_fetch_assoc($result)) {
    // Display the case details in an uneditable form
    echo '<form>';

    echo '<div class="form-group">';
    echo '<label for="name">Name:</label>';
    echo '<input type="text" id="name" value="' . htmlspecialchars($row['name']) . '" readonly>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="id_number">ID Number:</label>';
    echo '<input type="text" id="id_number" value="' . htmlspecialchars($row['id_number']) . '" readonly>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="mobile_no">Mobile Number:</label>';
    echo '<input type="text" id="mobile_no" value="' . htmlspecialchars($row['mobile_no']) . '" readonly>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="location">Location:</label>';
    echo '<input type="text" id="location" value="' . htmlspecialchars($row['location']) . '" readonly>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="occurrence_date">Occurrence Date:</label>';
    echo '<input type="date" id="occurrence_date" value="' . htmlspecialchars($row['occurence_date']) . '" readonly>';
    echo '</div>';

    // Format occurrence time
    $time = htmlspecialchars($row['occurence_time']);
    $formatted_time = date("H:i", strtotime($time));
    echo '<div class="form-group">';
    echo '    <label for="occurrence_time">Occurrence Time:</label>';
    echo '    <input type="time" id="occurrence_time" value="' . $formatted_time . '" readonly>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="description">Description:</label>';
    echo '<textarea id="description" readonly>' . htmlspecialchars($row['description']) . '</textarea>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '<label for="uploaded_id">Uploaded ID:</label>';
    echo '<a href="../FRONTEND/' . htmlspecialchars($row['id_upload']) . '" target="_blank">';
    echo '<img src="../FRONTEND/' . htmlspecialchars($row['id_upload']) . '" alt="ID Upload" class="id-upload-img">';
    echo '</a>';
    echo '</div>';

    // Buttons for Verify Case and Decline Case
    echo '<div class="buttons-container">';
    echo '<button type="button" class="verify-btn" onclick="verifyCase()">Verify Case</button>';
    echo '<button type="button" class="decline-btn" onclick="declineCase()">Decline Case</button>';
    echo '</div>';

    echo '</form>';
} else {
    // Display an error message if the case data is not found
    echo "<p>Case not found.</p>";
}

echo '</div>';
echo '</body>';
echo '</html>';

// Add the SweetAlert2 script and custom script for handling the button clicks
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script>';
echo 'function verifyCase() {';
echo '    Swal.fire({';
echo '        title: "Good job!",';
echo '        text: "You verified the case!",';
echo '        icon: "success"';
echo '    }).then((result) => {';
echo '        if (result.isConfirmed) {';
echo '            window.location.href = "verify_update.php?id_number=' . $id_number . '";';
echo '        }';
echo '    });';
echo '}';

echo 'function declineCase() {';
echo '    Swal.fire({';
echo '        title: "Are you sure?",';
echo '        text: "This action will decline the case!",';
echo '        icon: "warning",';
echo '        showCancelButton: true,';
echo '        confirmButtonText: "Yes, Decline the case!",';
echo '        cancelButtonText: "Cancel"';
echo '    }).then((result) => {';
echo '        if (result.isConfirmed) {';
echo '            window.location.href = "decline_case.php?id_number=' . $id_number . '";';
echo '        }';
echo '    });';
echo '}';
echo '</script>';

// Close the database connection
mysqli_close($conn);
?>