<?php
// Include the database connection
include '../Database/db_con.php';

// Include PHPMailer for email functionality
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Function to generate a unique OB number
function generate_ob_number($conn) {
    for ($attempts = 0; $attempts < 10; $attempts++) {
        $ob_number = strval(rand(1000, 9999));
        $query = "SELECT COUNT(*) as count FROM verified WHERE ob_number = '$ob_number'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] == 0) {
            return $ob_number;
        }
    }
    return false;
}

// Get the case number from the URL
$case_number = isset($_GET['case_number']) ? mysqli_real_escape_string($conn, $_GET['case_number']) : '';

if ($case_number) {
    $select_query = "SELECT * FROM cases WHERE case_number = '$case_number'";
    $result = mysqli_query($conn, $select_query);

    if (mysqli_num_rows($result) > 0) {
        $case_details = mysqli_fetch_assoc($result);

        $name = mysqli_real_escape_string($conn, $case_details['name']);
        $id_number = mysqli_real_escape_string($conn, $case_details['id_number']);
        $mobile_no = mysqli_real_escape_string($conn, $case_details['mobile_no']);
        $location = mysqli_real_escape_string($conn, $case_details['location']);
        $occurence_date = mysqli_real_escape_string($conn, $case_details['occurence_date']);
        $occurence_time = mysqli_real_escape_string($conn, $case_details['occurence_time']);
        $description = mysqli_real_escape_string($conn, $case_details['description']);
        $id_upload = mysqli_real_escape_string($conn, $case_details['id_upload']);
        $email = mysqli_real_escape_string($conn, $case_details['email']);

        $ob_number = generate_ob_number($conn);

        if ($ob_number) {
            $insert_query = "INSERT INTO verified (ob_number, name, id_number, mobile_no, location, occurence_date, occurence_time, description, id_upload, email, status) 
                             VALUES ('$ob_number', '$name', '$id_number', '$mobile_no', '$location', '$occurence_date', '$occurence_time', '$description', '$id_upload', '$email', 'verified')";

            if (mysqli_query($conn, $insert_query)) {
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
                        $pdf_content = generate_pdf($ob_number, $case_details); // Function to generate PDF content
                        $mail->addStringAttachment($pdf_content, 'Verified_Case_Details.pdf');

                        // Inline logo
                        $mail->AddEmbeddedImage('images/sondu_logo.png', 'logo'); // Specify the path to your logo

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Case Verified Notification';
                        $mail->Body    = '
                        <div style="font-family: Arial, sans-serif; color: #333;">
                            <h2>Case Verified Successfully</h2>
                            <p>Dear ' . $case_details['name'] . ',</p>
                            <p>Your case with the following details has been verified successfully:</p>
                            <ul>
                                <li><strong>Case Number:</strong> ' . $case_details['case_number'] . '</li>
                                <li><strong>OB Number:</strong> ' . $ob_number . '</li>
                            </ul>
                            <p>Please find the attached PDF for more details.</p>
                            <p>Best regards,</p>
                            <p>Sondu Police Station</p>
                            <img src="cid:logo" alt="Company Logo" style="width:100px;">
                        </div>';

                        $mail->send();

                        // Output JavaScript for SweetAlert and redirection
                        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                        echo '<script>
                            Swal.fire({
                                icon: "success",
                                title: "Case Verified Successfully",
                                text: "The case has been verified and the user has been notified.",
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
                echo "Error inserting case into 'verified' table: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Unable to generate a unique OB number.";
        }
    } else {
        echo "Case not found.";
    }
} else {
    echo "Invalid case number.";
}

mysqli_close($conn);
// Function to generate PDF content
function generate_pdf($ob_number, $case_details) {
    // Load the FPDF library
    require('../fpdf/fpdf.php');

    // Create instance of FPDF class
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font for title
    $pdf->SetFont('Arial', 'B', 16);

    // Add logo
    $pdf->Image('images/sondu_logo.png', 10, 6, 30);
    $pdf->Cell(40); // Move to the right

    // Title
    $pdf->Cell(110, 10, 'Verified Case Details', 0, 1, 'C');

    // Line break
    $pdf->Ln(20);

    // Set font for case details
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(50, 50, 50);

    // Add case details
    $pdf->Cell(50, 10, 'Case Number:', 0, 0);
    $pdf->Cell(50, 10, $case_details['case_number'], 0, 1);
    
    $pdf->Cell(50, 10, 'OB Number:', 0, 0);
    $pdf->Cell(50, 10, $ob_number, 0, 1);
    
    $pdf->Cell(50, 10, 'Name:', 0, 0);
    $pdf->Cell(50, 10, $case_details['name'], 0, 1);
    
    $pdf->Cell(50, 10, 'ID Number:', 0, 0);
    $pdf->Cell(50, 10, $case_details['id_number'], 0, 1);
    
    $pdf->Cell(50, 10, 'Mobile No:', 0, 0);
    $pdf->Cell(50, 10, $case_details['mobile_no'], 0, 1);
    
    $pdf->Cell(50, 10, 'Location:', 0, 0);
    $pdf->Cell(50, 10, $case_details['location'], 0, 1);
    
    $pdf->Cell(50, 10, 'Occurrence Date:', 0, 0);
    $pdf->Cell(50, 10, $case_details['occurence_date'], 0, 1);
    
    $pdf->Cell(50, 10, 'Occurrence Time:', 0, 0);
    $pdf->Cell(50, 10, $case_details['occurence_time'], 0, 1);
    
    $pdf->Cell(50, 10, 'Description:', 0, 0);
    $pdf->MultiCell(0, 10, $case_details['description']);
    
    $pdf->Cell(50, 10, 'Email:', 0, 0);
    $pdf->Cell(50, 10, $case_details['email'], 0, 1);

    // Add footer
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 10, 'Generated by Sondu Police Station', 0, 1, 'C');

    // Output PDF as a string
    return $pdf->Output('S');
}

?>
