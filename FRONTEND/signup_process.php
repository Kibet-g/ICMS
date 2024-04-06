<?php
include '../Database/db_con.php';

if (!empty($_POST)) {
  $message = "";

  if (empty($_POST['idtype']) || empty($_POST['name']) || empty($_POST['id_number']) || empty($_POST['email']) || empty($_POST['mobile_no']) || empty($_POST['password']) || empty($_POST['confirmpassword']) || !isset($_POST['terms'])) {
    $message .= "<div class='error_message'>All fields are required.</div>";
  }

  // Validate name to contain only letters, spaces, and apostrophes
  if (!preg_match("/^[a-zA-Z\s']+$/", $_POST['name'])) {
    $message .= "<div class='error_message'>Name can only contain letters, spaces, and apostrophes.</div>";
  }

  if ($_POST['password'] != $_POST['confirmpassword']) {
    $message .= "<div class='error_message'>Passwords do not match. Please enter matching passwords.</div>";
  }

// Enforce password complexity
if (strlen($_POST['password']) < 8 || !preg_match("/\d/", $_POST['password']) || !preg_match("/[a-z]/", $_POST['password']) || !preg_match("/[A-Z]/", $_POST['password']) || !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $_POST['password'])) {
    $message .= "<div class='error_message'>Password must be at least 8 characters and contain at least one digit, one uppercase letter, one lowercase letter, and one special character.</div>";
  }
  

  if (strlen($_POST['mobile_no']) > 10) {
    $message .= "<div class='error_message'>Mobile number should not be greater than 10 digits.</div>";
  }

  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $message .= "<div class='error_message'>Invalid email format. Please enter a valid email address.</div>";
  }

  if (!isset($_POST['terms'])) {
    $message .= "<div class='error_message'>Please accept the terms and conditions.</div>";
  }

  // Check for existing ID number or email
  $id_number = $_POST['id_number'];
  $email = $_POST['email'];
  $check_id_number_query = "SELECT * FROM users WHERE id_number = '$id_number'";
  $check_email_query = "SELECT * FROM users WHERE email = '$email'";
  $id_number_result = mysqli_query($conn, $check_id_number_query);
  $email_result = mysqli_query($conn, $check_email_query);

  if (mysqli_num_rows($id_number_result) > 0) {
    $message .= "<div class='error_message'>User with this ID number already exists.</div>";
  }

  if (mysqli_num_rows($email_result) > 0) {
    $message .= "<div class='error_message'>User with this email already exists.</div>";
  }

  if ($message != "") {
    echo $message;
  } else {
    // Process registration if no errors
    $idtype = $_POST['idtype'];
    $name = $_POST['name'];
    $id_number = $_POST['id_number'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];

    // Hash password before storing
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (idtype, name, id_number, email, mobile_no, password) VALUES ('$idtype', '$name', '$id_number', '$email', '$mobile_no', '$password')";
}
?>