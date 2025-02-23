<?php
<<<<<<< HEAD
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

include '../Database/db_con.php';
?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/ICMSSYSTEM/FRONTEND/constants/homeheader.php";
=======
//ONE CANT ACCESS THIS PAGE WITHOUT LOGGING IN
include './constants/authenticator.php';
include './constants/homeheader.php';
<<<<<<< HEAD
>>>>>>> 2546f13 (Changes on the site)
=======

// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user details from the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$mobile_no = isset($_SESSION['mobile_no']) ? $_SESSION['mobile_no'] : '';
>>>>>>> 4f059c1 (Made changes for our files)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sondu Police Station</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
</head>
<body>
    <main>
        <div class="container">
            <section class="categories">
                <h2>CATEGORIES</h2>
                <div class="categories__item">
<<<<<<< HEAD
                    <a href="report.php">
=======
                    <a href="upload_case.php">
>>>>>>> 2546f13 (Changes on the site)
                        <img src="IMAGES/reportcase.svg" alt="Report Case/Incident">
                        <h3>REPORT CASE/INCIDENT</h3>
                    </a>
                </div>
                <div class="categories__item">
<<<<<<< HEAD
                    <a href="#">
=======
                    <a href="track_case.php">
>>>>>>> 2546f13 (Changes on the site)
                        <img src="IMAGES/track_case.svg" alt="Track Case">
                        <h3>TRACK CASE</h3>
                    </a>
                </div>
                <div class="categories__item">
                    <a href="#" id="community-donations">
                        <img src="IMAGES/community.svg" alt="Community Engagement">
                        <h3>COMMUNITY DONATIONS</h3>
                    </a>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.getElementById('community-donations').addEventListener('click', function(event) {
            event.preventDefault();

            // Fetch user details from PHP
            const userDetails = {
                name: "<?php echo $name; ?>",
                email: "<?php echo $email; ?>",
                mobile_no: "<?php echo $mobile_no; ?>"
            };

            Swal.fire({
                title: 'Community Donations',
                html: `<input type="text" id="name" class="swal2-input" value="${userDetails.name}" readonly>
                       <input type="email" id="email" class="swal2-input" value="${userDetails.email}" readonly>
                       <input type="tel" id="mobile_no" class="swal2-input" value="${userDetails.mobile_no}">
                       <input type="number" id="amount" class="swal2-input" placeholder="Donation Amount" min="50">`,
                confirmButtonText: 'Donate',
                focusConfirm: false,
                preConfirm: () => {
                    const mobile_no = Swal.getPopup().querySelector('#mobile_no').value;
                    const amount = Swal.getPopup().querySelector('#amount').value;
                    if (!mobile_no || !amount || amount < 50) {
                        Swal.showValidationMessage(`Please enter a valid mobile number and a donation amount of at least 50 Kenyan Shillings`);
                    }
                    return { mobile_no: mobile_no, amount: amount };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Handle the donation details (e.g., send to the server or display a success message)
                    console.log(result.value);
                    Swal.fire(`Thank you for your donation, ${userDetails.name}!`);
                }
            });
        });
    </script>
</body>
</html>
