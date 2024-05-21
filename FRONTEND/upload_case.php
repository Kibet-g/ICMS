<?php
//ONE CANT ACCESS THIS PAGE WITHOUT LOGGING IN
include './constants/authenticator.php';
?>
<?php
include '../Database/db_con.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $email = isset($_POST['email'])? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $id_number = isset($_POST['id_number']) ? mysqli_real_escape_string($conn, $_POST['id_number']) : '';
    $mobile_no = isset($_POST['mobile_no']) ? mysqli_real_escape_string($conn, $_POST['mobile_no']) : '';
    $location = isset($_POST['location']) ? mysqli_real_escape_string($conn, $_POST['location']) : '';
    $occurrence_date = isset($_POST['occurrence_date']) ? mysqli_real_escape_string($conn, $_POST['occurrence_date']) : '';
    $occurrence_time = isset($_POST['occurrence_time']) ? mysqli_real_escape_string($conn, $_POST['occurrence_time']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    
    // Query to fetch user details
    $user_id = $_SESSION['email']; //EMAIL is stored in session after login
    $user_query = "SELECT name, email, id_number, mobile_no FROM users WHERE email = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);
    $user_row = mysqli_fetch_assoc($user_result);
    
    // Countercheck details
    if ($user_row['name'] !== $name || $user_row['email'] !== $email || $user_row['id_number'] !== $id_number || $user_row['mobile_no'] !== $mobile_no) {
        // Display error message using JavaScript alert
        echo "<script>";
        echo "alert('Please enter your own details As Per Your Registration Check View Detaills for Your Information.');";
        echo "window.location.href = 'upload_case.php';";
        echo "</script>";
        exit; // Stop further execution
    }
    

    // Continue with file upload and case submission
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Continue with file upload and case submission
        $fileName = $_FILES["image"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        $tempName = $_FILES["image"]["tmp_name"];
        $targetPath = "case-uploads/" . $fileName;
        
        // Check file extension
        if (in_array($ext, $allowedTypes)) {
            // Move the uploaded file
            if (move_uploaded_file($tempName, $targetPath)) {
                // Insert data into the database
                $query = "INSERT INTO cases (name, email, id_number, mobile_no, location, occurence_date, occurence_time, description, id_upload)
          VALUES ('$name', '$email', '$id_number', '$mobile_no', '$location', '$occurrence_date', '$occurrence_time', '$description', '$targetPath')";

                // Check if the query was successful
                if (mysqli_query($conn, $query)) {
                    header("Location: home.php");
                } else {
                    echo "Error inserting data into the database.";
                }
            } else {
                echo "File upload failed.";
            }
        } else {
            echo "Unsupported file type.";
        }
    } else {
        echo "Please provide a valid file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Case Form</title>
    <link rel="stylesheet" href="css/upload_case.css">
</head>
<body>
    <div class="header">
        <div class="report-form">
            <h2>Report Case</h2>
            <h4>Report case and submit it below for investigation</h4>
            <form method="POST" enctype="multipart/form-data" action="upload_case.php">
                Name: <input type="text" name="name" required><br><br>
                Email: <input type="text" name="email" required><br><br>
                ID Number: <input type="text" name="id_number" required><br><br>
                Phone Number: <input type="text" name="mobile_no" required><br><br>
                Location: <input type="text" name="location" required><br><br>
                Date of Occurrence: <input type="date" name="occurrence_date" required><br><br>
                Time of Occurrence: <input type="time" name="occurrence_time" required><br><br>
                Description: <textarea name="description" required></textarea><br><br>
                Upload ID: <input type="file" name="image" required><br><br>
                <input type="submit" value="Submit" class="report-btn">
            </form>
        </div>
    </div>
</body>
</html>
