<?php
// Include the database connection
include '../Database/db_con.php';

// Retrieve the case_number from the URL parameter
$case_number = isset($_GET['case_number']) ? mysqli_real_escape_string($conn, $_GET['case_number']) : '';

// Query to retrieve data from the `cases` table using the case_number
$query = "SELECT * FROM cases WHERE case_number = '$case_number'";
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
    echo '<label for="case_number">Case Number:</label>';
    echo '<input type="text" id="case_number" value="' . htmlspecialchars($row['case_number']) . '" readonly>';
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
    echo '<label for="occurrence_time">Occurrence Time:</label>';
    echo '<input type="time" id="occurrence_time" value="' . $formatted_time . '" readonly>';
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
    echo '<button type="button" class="decline-btn" onclick="confirmDecline()">Decline Case</button>';
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
echo '        title: "Are you sure?",';
echo '        text: "Do you want to verify this case?",';
echo '        icon: "warning",';
echo '        showCancelButton: true,';
echo '        confirmButtonText: "Yes, verify it!",';
echo '        cancelButtonText: "No, cancel!"';
echo '    }).then((result) => {';
echo '        if (result.isConfirmed) {';
echo '            showverifyCase();';
echo '        }';
echo '    });';
echo '}';

echo 'function showverifyCase() {';
echo '    Swal.fire({';
echo '        title: "Good job!",';
echo '        text: "You verified the case!",';
echo '        icon: "success"';
echo '    }).then((result) => {';
echo '        if (result.isConfirmed) {';
echo '            window.location.href = "verify_update.php?case_number=' . $case_number . '";';
echo '        }';
echo '    });';
echo '}';


echo 'function showverifyCase() {';
    echo '    Swal.fire({';
    echo '        title: "Good job!",';
    echo '        text: "You verified the case!",';
    echo '        icon: "success"';
    echo '    }).then((result) => {';
    echo '        if (result.isConfirmed) {';
    echo '            fetch("verify_update.php?case_number=' . $case_number . '")';
    echo '            .then(response => {';
    echo '                if(response.ok) {';
    echo '                    window.location.href = "assigned_cases.php";';
    echo '                } else {';
    echo '                    throw new Error("Verification failed");';
    echo '                }';
    echo '            })';
    echo '            .catch(error => {';
    echo '                console.error("Error:", error);';
    echo '            });';
    echo '        }';
    echo '    });';
    echo '}';
    

echo 'function confirmDecline() {';
echo '    Swal.fire({';
echo '        title: "Are you sure?",';
echo '        text: "Do you want to decline this case?",';
echo '        icon: "warning",';
echo '        showCancelButton: true,';
echo '        confirmButtonText: "Yes, decline it!",';
echo '        cancelButtonText: "No, cancel!"';
echo '    }).then((result) => {';
echo '        if (result.isConfirmed) {';
echo '            showDeclineForm();';
echo '        }';
echo '    });';
echo '}';

echo 'function showDeclineForm() {';
echo '    Swal.fire({';
echo '        title: "Decline Case",';
echo '        html: `';
echo '            <form id="decline-form">';
echo '                <input type="hidden" name="case_number" value="' . htmlspecialchars($case_number) . '">';
echo '                <div class="form-group">';
echo '                    <label for="decline_reason">Reason for Decline:</label>';
echo '                    <textarea id="decline_reason" name="decline_reason" required></textarea>';
echo '                </div>';
echo '                <div class="buttons-container">';
echo '                    <button type="button" class="decline-btn" onclick="submitDecline()">Submit Decline</button>';
echo '                </div>';
echo '            </form>`,';
echo '        showCancelButton: false,';
echo '        showConfirmButton: false';
echo '    });';
echo '}';

echo 'function submitDecline() {';
echo '    const formData = new FormData(document.getElementById("decline-form"));';
echo '    fetch("decline_case.php", { method: "POST", body: formData })';
echo '    .then(response => {';
echo '        if(response.ok) {';
echo '            Swal.fire({';
echo '                title: "Case Declined!",';
echo '                text: "Your case has been declined successfully.",';
echo '                icon: "success"';
echo '            }).then(() => {';
echo '                window.location.href = "assigned_cases.php";';
echo '            });';
echo '        } else {';
echo '            throw new Error("Network response was not ok");';
echo '        }';
echo '    })';
echo '    .catch(error => {';
echo '        console.error("Error submitting decline form:", error);';
echo '    });';
echo '}';

echo '</script>';

// Close the database connection
mysqli_close($conn);
?>
