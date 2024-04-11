<?php
// Include the database connection file
include '../Database/db_con.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $occurrence_date = mysqli_real_escape_string($conn, $_POST['occurrence_date']);
    $occurrence_time = mysqli_real_escape_string($conn, $_POST['occurrence_time']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // File upload handling for ID document
    $target_dir = "FRONTEND/document_images"; // Specify the directory where you want to save your files
    $target_file = $target_dir . basename($_FILES["id_upload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid image file
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["id_upload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["id_upload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk) {
        $target_directory = "FRONTEND/document_images/";
        $target_file = $target_directory . basename($_FILES["id_upload"]["name"]);
        
        if (move_uploaded_file($_FILES["id_upload"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert data into database
            $sql = "INSERT INTO cases (name, id_number, mobile_no, location, occurrence_date, occurrence_time, description, id_upload)
            VALUES ('$phone_number', '$id_number', '$phone_number', '$location', '$occurrence_date', '$occurrence_time', '$description', '$target_file')";
            
            if(mysqli_query($conn, $sql)){
                echo "Records added successfully.";
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    

    // Close connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Report Case Form</title>
    <link rel="stylesheet" href="css/report.css">
    
  </div>
</head>
<body>
    <div class="header">
<div class="report-form">
<h2>Report Case</h2>
<h4>Report case and submit it below for investigation</h4>
<form method="post" enctype="multipart/form-data">
    Phone Number: <input type="text" name="phone_number" required><br><br>
    Location: <input type="text" name="location" required><br><br>
    Date of Occurrence: <input type="date" name="occurrence_date" required><br><br>
    Time of Occurrence: <input type="time" name="occurrence_time" required><br><br>
    ID Number: <input type="text" name="id_number" required><br><br>
    Description: <textarea name="description" required></textarea><br><br>
    Upload ID: <input type="file" name="id_upload" id="id_upload" required><br><br>
    <input type="submit" name="submit" value="Submit" class="report-btn">
</form>
</div>
</body>
</html>
