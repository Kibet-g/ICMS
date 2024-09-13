<?php
// Include the database connection
include '../Database/db_con.php';

// Include PHPMailer for email functionality
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the case_number and decline reason from the POST request
$case_number = isset($_POST['case_number']) ? mysqli_real_escape_string($conn, $_POST['case_number']) : '';
$decline_reason = isset($_POST['decline_reason']) ? mysqli_real_escape_string($conn, $_POST['decline_reason']) : '';

// Retrieve case details before declining
$select_query = "SELECT * FROM cases WHERE case_number = '$case_number'";
$result = mysqli_query($conn, $select_query);

// Check if the case exists
if (mysqli_num_rows($result) > 0) {
    // Fetch case details
    $case_details = mysqli_fetch_assoc($result);

    // Insert the case details into the 'declined' table with the decline reason
    $insert_query = "INSERT INTO declined (name, id_number, mobile_no, location, occurence_date, occurence_time, id_upload, description, status, decline_reason, email, case_number) 
                     VALUES ('{$case_details['name']}', '{$case_details['id_number']}', '{$case_details['mobile_no']}', '{$case_details['location']}', 
                             '{$case_details['occurence_date']}', '{$case_details['occurence_time']}', '{$case_details['id_upload']}', 
                             '{$case_details['description']}', 'Declined-RE Submit', '$decline_reason', '{$case_details['email']}', '{$case_details['case_number']}')";

    if (mysqli_query($conn, $insert_query)) {
        // Delete the case from the 'cases' table
        $delete_query = "DELETE FROM cases WHERE case_number = '$case_number'";
        if (mysqli_query($conn, $delete_query)) {
            // Send email to the user
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
                $mail->addAddress($case_details['email']); // Add a recipient

                // Attachments
                $pdf_content = generate_pdf($case_number, $case_details, $decline_reason); // Function to generate PDF content
                $mail->addStringAttachment($pdf_content, 'Declined_Case_Details.pdf');

                // Inline logo
                $mail->AddEmbeddedImage('images/sondu_logo.png', 'logo'); // Specify the path to your logo

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Case Declined Notification';
                $mail->Body    = 'Dear ' . $case_details['name'] . ',<br><br>' .
                                  'Case Number: ' . $case_details['case_number'] . '<br><br>' .
                                 '<img src="cid:logo" alt="Company Logo" style="width:100px;"><br><br>' .
                                 'Hello and thank you for reporting an incident with us.<br><br>' .
                                 'Reason for decline: ' . $decline_reason . '<br><br>' .
                                 'Best regards,<br>Sondu Police station';

                $mail->send();

                // Output JavaScript for SweetAlert and redirection
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Case Declined Successfully",
                        text: "The case has been declined and the user has been notified.",
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location.href = "assigned_cases.php";
                    });
                </script>';
                exit;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error deleting case: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting case into 'declined' table: " . mysqli_error($conn);
    }
} else {
    echo "Case not found.";
}

// Close the database connection
mysqli_close($conn);

// Function to generate PDF content
function generate_pdf($case_number, $case_details, $decline_reason) {
    // Load the FPDF library
    require('../fpdf/fpdf.php');

    // Create instance of FPDF class
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(0, 10, 'Declined Case Details', 0, 1, 'C');

    // Line break
    $pdf->Ln(10);

    // Case details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Case Number: ' . $case_number, 0, 1);
    $pdf->Cell(0, 10, 'Name: ' . $case_details['name'], 0, 1);
    $pdf->Cell(0, 10, 'ID Number: ' . $case_details['id_number'], 0, 1);
    $pdf->Cell(0, 10, 'Mobile No: ' . $case_details['mobile_no'], 0, 1);
    $pdf->Cell(0, 10, 'Location: ' . $case_details['location'], 0, 1);
    $pdf->Cell(0, 10, 'Occurrence Date: ' . $case_details['occurence_date'], 0, 1);
    $pdf->Cell(0, 10, 'Occurrence Time: ' . $case_details['occurence_time'], 0, 1);
    $pdf->Cell(0, 10, 'Description: ' . $case_details['description'], 0, 1);
    $pdf->Cell(0, 10, 'Reason for Decline: ' . $decline_reason, 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $case_details['email'], 0, 1);

    // Output PDF as a string
    return $pdf->Output('S');
}
?>
