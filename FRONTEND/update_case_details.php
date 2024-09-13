<?php
include '../Database/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case_number = $_POST['case_number'];
    $name = $_POST['name'];
    $id_number = $_POST['id_number'];
    $mobile_no = $_POST['mobile_no'];
    $location = $_POST['location'];
    $occurence_date = $_POST['occurence_date'];
    $occurence_time = $_POST['occurence_time'];
    $description = $_POST['description'];
    $email = $_POST['email'];

    // Handle file upload
    $id_upload = "";
    if (isset($_FILES['id_upload']) && $_FILES['id_upload']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../FRONTEND/';
        $id_upload = basename($_FILES['id_upload']['name']);
        $target_file = $upload_dir . $id_upload;
        move_uploaded_file($_FILES['id_upload']['tmp_name'], $target_file);
    }

    // Save details to cases table
    $sql_insert = "INSERT INTO cases (case_number, name, id_number, mobile_no, location, occurence_date, occurence_time, id_upload, description, email) VALUES ('$case_number', '$name', '$id_number', '$mobile_no', '$location', '$occurence_date', '$occurence_time', '$id_upload', '$description', '$email')";
    $conn->query($sql_insert);

    // Delete from declined table
    $sql_delete = "DELETE FROM declined WHERE case_number = '$case_number'";
    $conn->query($sql_delete);

    echo "Case details updated successfully";
}

$conn->close();
?>
