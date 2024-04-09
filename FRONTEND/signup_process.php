<?php
include '../Database/db_con.php';

if(!empty($_POST))
{
    $message = "";

    if(empty($_POST['idtype']) || empty($_POST['name']) || empty($_POST['id_number']) || empty($_POST['email']) || empty($_POST['mobile_no']) || empty($_POST['password']) || empty($_POST['confirmpassword']) || empty($_POST['terms'])) 
    {
        $message .= "<div class='error_message'>All fields are required</div>";
    }
    
    if($_POST['password'] != $_POST['confirmpassword']) {
        $message .= "<div class='error_message'>Passwords do not match. Please enter matching passwords.</div>";
    }

    if(strlen($_POST['password']) > 10) {
        $message .= "<div class='error_message'>Password should not be greater than 10 characters.</div>";
    }

    if(strlen($_POST['mobile_no']) > 10) {
        $message .= "<div class='error_message'>Mobile number should not be greater than 10 digits.</div>";
    }

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message .= "<div class='error_message'>Invalid email format. Please enter a valid email address.</div>";
    }

    if(!isset($_POST['terms'])) {
        $message .= "<div class='error_message'>Please accept the terms and conditions.</div>";
    }

    // Check if the id_number already exists in the database
    $id_number = $_POST['id_number'];
    $check_id_number_query = "SELECT * FROM users WHERE id_number = '$id_number'";
    $id_number_result = mysqli_query($conn, $check_id_number_query);
    if(mysqli_num_rows($id_number_result) > 0) {
        // ID number already exists
        $message .= "<div class='error_message'>User with this ID number already exists.</div>";
    }

    // Check if the user already exists in the database using email
    $email = $_POST['email'];
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $email_result = mysqli_query($conn, $check_email_query);
    if(mysqli_num_rows($email_result) > 0) {
        // User already exists
        $message .= "<div class='error_message'>User with this email already exists.</div>";
    }

    if($message != "") {
        echo $message;
    }


    else {
        // Process registration if no errors
        $idtype = $_POST['idtype'];
        $name = $_POST['name'];
        $id_number = $_POST['id_number'];
        $email = $_POST['email'];
        $mobile_no = $_POST['mobile_no'];
        $password = $_POST['password'];
        
        // Insert user data into the database
        $query = "INSERT INTO users (idtype, name, id_number, email, mobile_no, password) 
                  VALUES ('$idtype', '$name', '$id_number', '$email', '$mobile_no', '$password')";
        
         else {
            // Error handling if insertion fails
            $message .= "<div class='error_message'>Error: " . mysqli_error($conn) . "</div>";
        }
        
        // Close database connection
        mysqli_close($conn);
    }

    // Display the message
    echo $message;
}
?>
