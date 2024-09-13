<?php
include '../Database/db_con.php';

if (isset($_POST['case_number'])) {
    $case_number = $_POST['case_number'];

    $sql = "SELECT * FROM declined WHERE case_number = '$case_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Case not found']);
    }
}
$conn->close();
?>
