<?php
// Include the database connection
include '../Database/db_con.php';

// Define variables to store form data
$criminal_id = $name = $age = $crime = $sentence = $image = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $criminal_id = mysqli_real_escape_string($conn, $_POST['criminal_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $crime = mysqli_real_escape_string($conn, $_POST['crime']);
    $sentence = mysqli_real_escape_string($conn, $_POST['sentence']);
    $created_at = date('Y-m-d H:i:s'); // Set the current date and time

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];
        $image_type = $_FILES['image']['type'];

        $image_ext = explode('.', $image_name);
        $image_actual_ext = strtolower(end($image_ext));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($image_actual_ext, $allowed)) {
            if ($image_error === 0) {
                if ($image_size < 5000000) { // Limit file size to 1MB
                    $image_new_name = uniqid('', true) . "." . $image_actual_ext;
                    $image_destination = 'criminal-uploads/' . $image_new_name;
                    move_uploaded_file($image_tmp_name, $image_destination);
                    $image = $image_new_name;
                } else {
                    $error_message = "Error: Your file is too large!";
                }
            } else {
                $error_message = "Error: There was an error uploading your file!";
            }
        } else {
            $error_message = "Error: You cannot upload files of this type!";
        }
    } else {
        $error_message = "Error: No file uploaded!";
    }

    if (empty($error_message)) {
        // Check if the criminal ID already exists
        $check_criminal_id_query = "SELECT * FROM criminals WHERE criminal_id = '$criminal_id'";
        $result_criminal_id = mysqli_query($conn, $check_criminal_id_query);

        if (mysqli_num_rows($result_criminal_id) > 0) {
            // Set error message for duplicate criminal ID
            $error_message = "Error: Criminal ID already exists!";
        } else {
            // Insert the criminal record into the database
            $insert_query = "INSERT INTO criminals (criminal_id, name, age, crime, sentence, created_at, image) VALUES ('$criminal_id', '$name', '$age', '$crime', '$sentence', '$created_at', '$image')";
            if (mysqli_query($conn, $insert_query)) {
                // Set success message
                $success_message = "Criminal added successfully!";
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Criminal</title>
    <link rel="stylesheet" href="css/add_criminal.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-top: 5px;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            display: block;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'constants/sidebar_header.php'; ?>

    <?php if (!empty($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $error_message; ?>'
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $success_message; ?>'
            });
        </script>
    <?php endif; ?>

    <div class="main-content">
        <div class="container">
            <h2>Add Criminal</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="criminal_id">Criminal ID:</label>
                    <input type="text" id="criminal_id" name="criminal_id" required>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="crime">Crime:</label>
                    <input type="text" id="crime" name="crime" required>
                </div>
                <div class="form-group">
                    <label for="sentence">Sentence:</label>
                    <input type="text" id="sentence" name="sentence" required>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit">Add Criminal</button>
            </form>
        </div>
    </div>
</body>
</html>
