<?php
    // Start session management
    session_start();

    // Redirect to welcome page if user is already logged in
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    // Include database connection file
    include '../Database/db_con.php';

    // Initialize message variable
    $msg = "";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check for and handle form validation errors
        $errors = array();
        if(empty($_POST['idtype'])) {
            $errors['idtype'] = "Identification Document Type is required";
        }
        // Validate name to contain only letters, spaces, and apostrophes
        if(empty($_POST['name'])) {
            $errors['name'] = "Name as per your ID is required";
        }
        if (!preg_match("/^[a-zA-Z\s']+$/", $_POST['name'])) {
            $errors['name']= "<div class='error_message'>Name can only contain letters, spaces, and apostrophes.</div>";
        }
        // Validate other required fields similarly...

        // Validate password complexity
        $password = $_POST['password'];
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/", $password)) {
            $errors['password'] = "Password must contain at least 8 characters, including uppercase, lowercase letters, numbers, and special characters.";
        }

        // If there are no validation errors, check for duplicate entries and then insert data into the database
        if (empty($errors)) {
            // Retrieve form data
            $idtype = $_POST['idtype'];
            $name = $_POST['name'];
            $id_number = $_POST['id_number'];
            $email = $_POST['email'];
            $mobile_no = $_POST['mobile_no'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

            // Check if the user already exists in the database
            $query = "SELECT * FROM users WHERE email='$email' OR id_number='$id_number' OR mobile_no='$mobile_no'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<div style='color:red;'>Error: The details are already in the database.</div>";
            } else {
                // Insert data into the database
                $sql = "INSERT INTO users (idtype, name, id_number, email, mobile_no, password) 
                        VALUES ('$idtype', '$name', '$id_number', '$email', '$mobile_no', '$password')";

                // Execute the query and handle success/error
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<div style='color:blue;'>Signup successful!</div>";
                    header("Location: login.php");
                    // Further processing like sending verification email can be added here
                } else {
                    echo "<div style='color:red;'>Error: " . mysqli_error($conn) . "</div>";
                }
            }
        } else {
            // Display validation errors
            echo "<div style='color:red;'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign Up Form</title>
</head>
<body>
    <!-- Signup form -->
    <div class="signup-form">
        <h1>Sign Up</h1>
        <p>Just a breather and you are up and running</p>
        <!-- Signup form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <!-- Input fields for user data -->
            <select name="idtype" class="custom-select">
                <option value="National ID">National ID</option>
                <option value="Passport">Passport</option>
            </select>
            <input type="text" name="name" placeholder="Name as per your ID" pattern="[A-Za-z ]+" title="Name should contain only alphabetic characters">
            <input type="number" name="id_number" placeholder="ID Number Or Passport Number">
            <input type="email" name="email" placeholder="Email Address">
            <input type="number" name="mobile_no" placeholder="Mobile Number">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="confirmpassword" placeholder="Confirm Password">
            <label><input type="checkbox" name="terms"> <a href="terms and conditions.html">I have read and agreed with the Terms and Conditions</a></label>
            <br>
            <button type="submit" class="signup-btn">Sign Up</button>
        </form>
        <!-- Link to login page -->
        <p>Already Have an account? <a href="login.php">Log in</a></p>
    </div>
</body>
</html>
