<?php
include '../Database/db_con.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=report.csv');

// Open the output stream
$output = fopen('php://output', 'w');

// Function to write table data to CSV
function writeTableToCSV($conn, $tableName, $output) {
    // Fetch data from the table
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    // Write column headers
    $columns = array();
    while ($fieldinfo = $result->fetch_field()) {
        $columns[] = $fieldinfo->name;
    }
    fputcsv($output, $columns);

    // Write rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fputcsv($output, []); // Add an empty line for separation
}

// List of tables to export
$tables = ['users', 'police', 'verified', 'declined', 'event_logs'];

// Write each table to the CSV
foreach ($tables as $table) {
    // Write table name
    fputcsv($output, [$table]);
    // Write table data
    writeTableToCSV($conn, $table, $output);
}

fclose($output);
$conn->close();
exit;
?>
