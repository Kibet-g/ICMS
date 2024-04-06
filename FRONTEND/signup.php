<?php
// Include the database connection file
include '../Database/db_con.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if any required fields are empty
    $errors = array();
    if(empty($_POST['idtype'])) {
        $errors['idtype'] = "Identification Document Type is required";
    }
    if(empty($_POST['name'])) {
        $errors['name'] = "Name as per your ID is required";
    }
    
  if (!preg_match("/^[a-zA-Z\s']+$/", $_POST['name'])) {
    $errors['name']= "<div class='error_message'>Name can only contain letters, spaces, and apostrophes.</div>";
  }
    if(empty($_POST['id_number'])) {
        $errors['id_number'] = "ID Number is required";
    }
    if(empty($_POST['email'])) {
        $errors['email'] = "Email Address is required";
    }
    if(empty($_POST['mobile_no'])) {
        $errors['mobile_no'] = "Mobile Number is required";
    }
    if(empty($_POST['password'])) {
        $errors['password'] = "Password is required";
    }
    if (strlen($_POST['password']) < 8 || !preg_match("/\d/", $_POST['password']) || !preg_match("/[a-z]/", $_POST['password']) || !preg_match("/[A-Z]/", $_POST['password']) || !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $_POST['password'])) {
        $errors['password']= "<div class='error_message'>Password must be at least 8 characters and contain at least one digit, one uppercase letter, one lowercase letter, and one special character.</div>";
      }
    if(empty($_POST['confirmpassword'])) {
        $errors['confirmpassword'] = "Confirm Password is required";
    }
    if(empty($_POST['terms'])) {
        $errors['terms'] = "You must agree to the Terms and Conditions";
    }

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        // Retrieve form data
        $idtype = $_POST['idtype'];
        $name = $_POST['name'];
        $id_number = $_POST['id_number'];
        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];
        $password = $_POST['password'];

        // Insert data into the database
        $query = "INSERT INTO users (idtype, name, id_number, email, mobile_no, password) 
                  VALUES ('$idtype', '$name', '$id_number', '$email', '$mobile_no', '$password')";
        
        // Execute the query
        if(mysqli_query($conn, $query)) {
            // Registration successful
            echo "<div style='color:blue;'>Signup successful!</div>";
            header("Location: login.php");
        } else {
            // Error handling if insertion fails
            echo "<div style='color:red;'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
    // If there are errors, display the form with error messages
    else {
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
<div class="signup-form">
  <h1>Sign Up</h1>
  <p>Just a breather and you are up and running</p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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

  <p>Already Have an account? <a href="login.php">Log in</a></p>
</div>

</body>
</html>
