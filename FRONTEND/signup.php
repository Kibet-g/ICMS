<?php
session_start(); // Start the session

// Include the database connection file
include '../Database/db_con.php';
include 'constants/log_event.php'; // EVENTS HAPPENING

if (isset($_POST['submit'])) {
    $errors = array(); // Initialize an empty array to store validation errors

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $id_number = mysqli_real_escape_string($conn, $_POST["id_number"]);
    $idtype = mysqli_real_escape_string($conn, $_POST["idtype"]);
    $mobile_no = mysqli_real_escape_string($conn, $_POST["mobile_no"]);
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $terms = isset($_POST["terms"]) ? 1 : 0; // Convert checkbox value to integer

    // Check if terms checkbox is checked
    if (!$terms) {
        $errors['terms'] = "You must agree to the terms and conditions";
    }

    // Validation checks
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z]+(?: [a-zA-Z]+)*$/", $name)) {
        $errors['name'] = "Name should contain only letters with optional space for multiple names";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }
    if (empty($id_number)) {
        $errors['id_number'] = "ID Number is required";
    } elseif (!preg_match("/^\d{8}$/", $id_number)) {
        $errors['id_number'] = "ID Number should have exactly 8 digits";
    }
    if (empty($idtype)) {
        $errors['idtype'] = "ID Type is required";
    }
    if (empty($mobile_no)) {
        $errors['mobile_no'] = "Mobile Number is required";
    } elseif (!preg_match("/^\d{10}$/", $mobile_no)) {
        $errors['mobile_no'] = "Mobile Number should have exactly 10 digits";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
        $errors['password'] = "Password must be at least 8 characters long and contain at least one number, one letter, and one special character";
    }
    if (empty($confirmpassword)) {
        $errors['confirmpassword'] = "Confirm Password is required";
    }
    if ($password != $confirmpassword) {
        $errors['confirmpassword'] = "Passwords do not match";
    }

    // If there are validation errors, store them in session and redirect to signup.php
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: signup.php");
        exit(); // Stop further execution
    }

    // Check if the id_number already exists in the database
    $check_id_number_query = "SELECT * FROM users WHERE id_number = '$id_number'";
    $id_number_result = mysqli_query($conn, $check_id_number_query);
    if(mysqli_num_rows($id_number_result) > 0) {
        // ID number already exists
        $_SESSION['error_message'] = "User with this ID number already exists.";
        header("Location: signup.php");
        exit(); // Stop further execution
    }

    // Check if the email already exists in the database
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $email_result = mysqli_query($conn, $check_email_query);
    if(mysqli_num_rows($email_result) > 0) {
        // Email already exists
        $_SESSION['error_message'] = "User with this email already exists.";
        header("Location: signup.php");
        exit(); // Stop further execution
    }

    // Check if the mobile number already exists in the database
    $check_mobile_query = "SELECT * FROM users WHERE mobile_no = '$mobile_no'";
    $mobile_result = mysqli_query($conn, $check_mobile_query);
    if(mysqli_num_rows($mobile_result) > 0) {
        // Mobile number already exists
        $_SESSION['error_message'] = "User with this mobile number already exists.";
        header("Location: signup.php");
        exit(); // Stop further execution
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $insert = "INSERT INTO users (name, email, id_number, idtype, mobile_no, password) VALUES ('$name', '$email', '$id_number', '$idtype', '$mobile_no', '$hashed_password')";
    $result = mysqli_query($conn, $insert) or die(mysqli_error($conn));
    if ($result) {

         // Log the signup event
         log_event($email, 'User signed up');

        $_SESSION['success_message'] = "User Created!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to create user. Please try again later.";
        header("Location: signup.php");
        exit();
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
<div class="signup-form">
    <h1>Sign Up</h1>
    <?php
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo "<p style='color:red'>$error</p>";
        }
        unset($_SESSION['errors']); // Clear errors from session after displaying
    }

    if (isset($_SESSION['error_message'])) {
        echo "<p style='color:red'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']); // Clear error message from session after displaying
    }

    if (isset($_SESSION['success_message'])) {
        echo "<p style='color:green'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']); // Clear success message from session after displaying
    }
    ?>
    <p>Just a breather and you are up and running</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <select name="idtype" class="custom-select">
            <option value="National ID">National ID</option>
            <option value="Passport">Passport</option>
        </select>
        <input type="text" name="name" placeholder="Name as per your ID">
        <input type="number" name="id_number" placeholder="ID Number Or Passport Number">
        <input type="email" name="email" placeholder="Email Address">
        <input type="number" name="mobile_no" placeholder="Mobile Number">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirmpassword" placeholder="Confirm Password">
        <label><input type="checkbox" name="terms"> <a href="terms and conditions.html">I have read and agreed with the Terms and Conditions</a></label>
        <br>
        <button type="submit" name="submit" class="signup-btn">Sign Up</button>
    </form>

    <p>Already Have an account? <a href="login.php">Log in</a></p>
</div>

</body>
</html>
