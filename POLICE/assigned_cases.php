<?php

include './CONSTANTS/authenticator.php';
// Include authentication and database connection
include './CONSTANTS/sidebar_header.php';
include '../Database/db_con.php';

// Query to retrieve data from the `cases` table
$query = "SELECT * FROM cases";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Start HTML output
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<title>Uploaded Cases</title>';
// Link to the external CSS file
echo '<link rel="stylesheet" href="css/assigned_cases.css">';
echo '</head>';
echo '<body>';

// Main content
echo '<div class="main-content">';
echo '<h2>Uploaded Cases</h2>';

// Start the HTML table
echo '<table>';
echo '<tr>';
echo '<th>Case Number</th>';
echo '<th>Name</th>';
echo '<th>Email</th>';
echo '<th>ID Number</th>';
echo '<th>Mobile Number</th>';
echo '<th>Location</th>';
echo '<th>Action</th>';
echo '</tr>';

// Counter for case number
$case_number = 1;

// Loop through the query results and display each row in the table
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['case_number']) . '</td>';
    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
    echo '<td>' . htmlspecialchars($row['id_number']) . '</td>';
    echo '<td>' . htmlspecialchars($row['mobile_no']) . '</td>';
    echo '<td>' . htmlspecialchars($row['location']) . '</td>';
    //Buttons for Verifying and Assigning OB number
    echo '<td style="display: flex; flex-direction: column; justify-content: center;">';
    echo '<a class="verify-btn" href="verify_case.php?case_number=' . urlencode($row['case_number']) . '">View case</a>';
    echo '</td>';
    echo '</tr>';
    $case_number++;
}

// End the HTML table
echo '</table>';

// End main content
echo '</div>';

// Close body and HTML
echo '</body>';
echo '</html>';

// Close database connection
mysqli_close($conn);
?>
