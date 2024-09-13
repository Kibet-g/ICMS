<?php
// ONE CANT ACCESS THIS PAGE WITHOUT LOGGING IN
include './constants/authenticator.php';
include '../Database/db_con.php';
include 'constants/log_event.php'; // Events Happening

// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Query to fetch user details
$user_id = $_SESSION['email']; // Assuming email is stored in session after login
$user_query = "SELECT name, email, id_number, mobile_no FROM users WHERE email = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user_row = mysqli_fetch_assoc($user_result);

// Query to fetch locations
$location_query = "SELECT id, location_name FROM locations";
$location_result = mysqli_query($conn, $location_query);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $id_number = isset($_POST['id_number']) ? mysqli_real_escape_string($conn, $_POST['id_number']) : '';
    $mobile_no = isset($_POST['mobile_no']) ? mysqli_real_escape_string($conn, $_POST['mobile_no']) : '';
    $location = isset($_POST['location']) ? mysqli_real_escape_string($conn, $_POST['location']) : '';
    $occurence_date = isset($_POST['occurence_date']) ? mysqli_real_escape_string($conn, $_POST['occurence_date']) : '';
    $occurence_time = isset($_POST['occurence_time']) ? mysqli_real_escape_string($conn, $_POST['occurence_time']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    
    // Countercheck details
    if ($user_row['name'] !== $name || $user_row['email'] !== $email || $user_row['id_number'] !== $id_number || $user_row['mobile_no'] !== $mobile_no) {
        // Display error message using JavaScript alert
        echo "<script>";
        echo "alert('Please enter your own details as per your registration.');";
        echo "window.location.href = 'upload_case.php';";
        echo "</script>";
        exit; // Stop further execution
    }
    
    // Check that the occurrence date and time are not in the future and not older than one week
    $currentDateTime = new DateTime();
    $minDateTime = clone $currentDateTime;
    $minDateTime->modify('-1 week');
    $occurenceDateTime = new DateTime("$occurence_date $occurence_time");
    
    // Continue with file upload and case submission
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
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
                          VALUES ('$name', '$email', '$id_number', '$mobile_no', '$location', '$occurence_date', '$occurence_time', '$description', '$targetPath')";
                
                // Check if the query was successful
                if (mysqli_query($conn, $query)) {
                    // Log the login event
                    log_event($email, 'User reported a case');
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
    <script>
        window.onload = function() {
            // Get current date and time
            var currentDateTime = new Date();
            var currentDate = currentDateTime.toISOString().split('T')[0];
            var currentTime = currentDateTime.toTimeString().split(' ')[0].slice(0, 5); // Only hours and minutes

            // Calculate the date one month ago
            var oneMonthAgo = new Date(currentDateTime);
            oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
            var oneMonthAgoDate = oneMonthAgo.toISOString().split('T')[0];

            // Set min and max attributes for date input
            var dateInput = document.getElementsByName("occurence_date")[0];
            var timeInput = document.getElementsByName("occurence_time")[0];
            var errDateTimeMsgO = document.getElementById("errDateTimeMsgO");

            dateInput.setAttribute('min', oneMonthAgoDate);
            dateInput.setAttribute('max', currentDate);

            // Set min attribute for time input
            var minTime = "00:00";
            timeInput.setAttribute('min', minTime);

            // Set max attribute for time input based on selected date
            dateInput.addEventListener('change', function() {
                updateMaxTime();
                validateDateTime();
            });

            timeInput.addEventListener('change', function() {
                validateDateTime();
            });

            // Initial setting if the page loads with today's date selected
            if (dateInput.value === currentDate) {
                timeInput.setAttribute('max', currentTime);
                if (timeInput.value > currentTime) {
                    timeInput.value = currentTime;
                }
            }

            function updateMaxTime() {
                if (dateInput.value === currentDate) {
                    timeInput.setAttribute('max', currentTime);
                } else {
                    timeInput.removeAttribute('max');
                }
            }

            function validateDateTime() {
                var selectedDateStr = dateInput.value;
                var selectedTimeStr = timeInput.value;

                // Ensure the date and time inputs are not empty
                if (!selectedDateStr || !selectedTimeStr) {
                    errDateTimeMsgO.innerHTML = "Please select both date and time.";
                    return;
                }

                var selectedDateTime = new Date(selectedDateStr + 'T' + selectedTimeStr);
                var nowDateTime = new Date();

                if (selectedDateTime > nowDateTime) {
                    errDateTimeMsgO.innerHTML = "The Date and Time you have selected is in the future.";
                } else {
                    errDateTimeMsgO.innerHTML = "";
                }
            }
        }
    </script>

</head>
<body>
    <div class="header">
        <div class="report-form">
            <h2>Report Case</h2>
            <h4>Report case and submit it below for investigation</h4>
            <form method="POST" enctype="multipart/form-data" action="upload_case.php">
                Name: <input type="text" name="name" value="<?php echo htmlspecialchars($user_row['name']); ?>" readonly><br><br>
                Email: <input type="text" name="email" value="<?php echo htmlspecialchars($user_row['email']); ?>" readonly><br><br>
                ID Number: <input type="text" name="id_number" value="<?php echo htmlspecialchars($user_row['id_number']); ?>" readonly><br><br>
                Phone Number: <input type="text" name="mobile_no" value="<?php echo htmlspecialchars($user_row['mobile_no']); ?>" readonly><br><br>
                Location: 
                <select name="location" required>
                    <option value="">Select a location</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($location_result)) {
                        echo "<option value=\"" . htmlspecialchars($row['location_name']) . "\">" . htmlspecialchars($row['location_name']) . "</option>";
                    }
                    ?>
                </select><br><br>
                Date of Occurrence: <input type="date" name="occurence_date" id="datepicker" required><br><br>
                Time of Occurrence: <input type="time" name="occurence_time" id="timepicker" required><br><br>
                <div id="errDateTimeMsgO" style="color: red;"></div>

                Description: <textarea name="description" required></textarea><br><br>
                Upload ID: <input type="file" name="image" required><br><br>
                <input type="submit" value="Submit" class="report-btn">
            </form>
        </div>
    </div>
</body>
</html>
