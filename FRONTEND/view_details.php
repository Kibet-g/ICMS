<?php
// Start the session
include './constants/authenticator.php';

// Include the database connection file
include '../Database/db_con.php';

// Initialize variables to avoid undefined variable warnings
$name = "";
$email = "";
$id_number = "";
$idtype = "";
$mobile_no = "";

// Check if the user is logged in (i.e., if their session is set)
if (isset($_SESSION['email'])) {
    // Fetch user details from the database using the session email
    $email = $_SESSION['email'];
    
    // Properly quote the email address in the SQL query
    $sql = "SELECT name, email, id_number, idtype, mobile_no FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $email = $row["email"];
            $id_number = $row["id_number"];
            $idtype = $row["idtype"];
            $mobile_no = $row["mobile_no"];
        }
    } else {
        echo "0 results";
    }
} else {
    // If the user is not logged in, redirect them to the login page or display a message
    // For example:
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view_details.css">
    <title>User Details</title>
    <!-- Include SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>User Details</h2>
            <form id="updateForm" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly><br><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>
                
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" readonly><br><br>
                
                <label for="idtype">ID Type:</label>
                <input type="text" id="idtype" name="idtype" value="<?php echo htmlspecialchars($idtype); ?>" readonly><br><br>
                
                <label for="mobile_no">Mobile Number:</label>
                <input type="text" id="mobile_no" name="mobile_no" value="<?php echo htmlspecialchars($mobile_no); ?>"><br><br>
                
                <input type="button" value="update" id="updateButton">
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#updateButton').on('click', function() {
            Swal.fire({
                title: "Do you want to change your details?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Change",
                denyButtonText: `Don't Change`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'update_details.php',
                        type: 'POST',
                        data: $('#updateForm').serialize(),
                        success: function(response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Your Details have been changed Successfully",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });
    });
    </script>
</body>
</html>
