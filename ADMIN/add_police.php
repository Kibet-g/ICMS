<?php
// Include the database connection
include '../Database/db_con.php';
include 'constants/sidebar.php';
// Include PHPMailer for email functionality
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Function to generate a strong password
function generateStrongPassword($length = 12) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}|:<>?-=[];,./';
    $charactersLength = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, $charactersLength - 1)];
    }
    return $password;
}

// Define variables to store form data
$police_id = $police_email = $name = $rank = $police_id_number = $phone_number = '';
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $police_id = mysqli_real_escape_string($conn, $_POST['police_id']);
    $police_email = mysqli_real_escape_string($conn, $_POST['police_email']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $police_id_number = mysqli_real_escape_string($conn, $_POST['police_id_number']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    // Check for duplicate police_id
    $check_id_query = "SELECT * FROM police WHERE police_id = '$police_id'";
    $result_id = mysqli_query($conn, $check_id_query);

    // Check for duplicate police_email
    $check_email_query = "SELECT * FROM police WHERE police_email = '$police_email'";
    $result_email = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result_id) > 0) {
        // Set error message for duplicate police_id
        $error_message = "Error: Police ID already exists!";
    } elseif (mysqli_num_rows($result_email) > 0) {
        // Set error message for duplicate police_email
        $error_message = "Error: Police Email already exists!";
    } else {
        // Generate a strong password
        $password = generateStrongPassword();

        // Insert the police record into the database
        $insert_query = "INSERT INTO police (police_id, police_email, password, name, rank, police_id_number, phone_number)
                         VALUES ('$police_id', '$police_email', '$password', '$name', '$rank', '$police_id_number', '$phone_number')";
        if (mysqli_query($conn, $insert_query)) {
            // Send email to the police officer with the password
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'kibetg984@gmail.com'; // SMTP username
                $mail->Password = 'qsgr ffuz syic piuz'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('kibetg984@gmail.com', 'Sondu Police Station');
                $mail->addAddress($police_email); // Add a recipient

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Account Details';
                $mail->Body    = '
                <div style="font-family: Arial, sans-serif; color: #333;">
                    <h2>Welcome to Sondu Police Station</h2>
                    <p>Dear ' . $name . ',</p>
                    <p>Your account has been created successfully. Here are your login details:</p>
                    <ul>
                        <li><strong>Email:</strong> ' . $police_email . '</li>
                        <li><strong>Password:</strong> ' . $password . '</li>
                        <li><strong>Phone Number:</strong> ' . $phone_number . '</li>
                    </ul>
                    <p>Please change your password after logging in for the first time.</p>
                    <p>Best regards,</p>
                    <p>Sondu Police Station</p>
                </div>';

                $mail->send();

                // Set success message
                $success_message = "Police officer added successfully!";
            } catch (Exception $e) {
                $error_message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error_message = "Error: " . mysqli_error($conn);
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
    <title>Add Police</title>
    <link rel="stylesheet" href="css/add_police.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding-top: 60px; /* Adjust this value according to the height of your navbar */
        }
        form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin-bottom: 5px;
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
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

    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="police_id">Police ID:</label>
            <input type="text" id="police_id" name="police_id" required>

            <label for="police_email">Police Email:</label>
            <input type="email" id="police_email" name="police_email" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="rank">Rank:</label>
            <select id="rank" name="rank" required>
                <option value="Constable">Constable</option>
                <option value="Corporal">Corporal</option>
                <!-- Add other options as needed -->
            </select>

            <label for="police_id_number">ID Number:</label>
            <input type="text" id="police_id_number" name="police_id_number" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>

            <button type="submit">Add Police</button>
        </form>
    </div>

</body>
</html>
