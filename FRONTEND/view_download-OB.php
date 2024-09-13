<?php
// Include the authenticator script to ensure the user is logged in
include './constants/authenticator.php';

// Include the database connection file
include '../Database/db_con.php';

// Retrieve the parameter from the URL
$id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : '';

if (!$id) {
    echo "Invalid request: No identifier provided.";
    exit();
}

// Assume the provided id is an ob_number
$ob_number = $id;

// Fetch the case details associated with the provided ob_number
$sql = "SELECT name, id_number,ob_number, mobile_no, location, occurence_date, occurence_time, id_upload, description, status FROM verified WHERE ob_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $ob_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No reported cases found or you do not have permission to view this case.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/track_case.css">
    <title>User Case PDF</title>
    <style>
        .pdf-container {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .pdf-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .pdf-container h2 {
            margin-bottom: 20px;
        }
        .pdf-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .pdf-container th, .pdf-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .pdf-container th {
            background-color: #f2f2f2;
        }
        .pdf-actions {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
        }
        .pdf-actions button {
            padding: 8px 16px;
            margin-right: 10px;
            background-color: #099c1f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="pdf-container" id="pdf-content">
            <img src="IMAGES/sondu_logo.png" alt="Logo">
            
            <h2>User Case Details</h2>
            <table>
                <tr><th>Name</th><td><?php echo htmlspecialchars($row["name"]); ?></td></tr>
                <tr><th>OB Number</th><td><?php echo htmlspecialchars($row["ob_number"]); ?></td></tr>
                <tr><th>ID Number</th><td><?php echo htmlspecialchars($row["id_number"]); ?></td></tr>
                <tr><th>Mobile Number</th><td><?php echo htmlspecialchars($row["mobile_no"]); ?></td></tr>
                <tr><th>Location</th><td><?php echo htmlspecialchars($row["location"]); ?></td></tr>
                <tr><th>Occurrence Date</th><td><?php echo htmlspecialchars($row["occurence_date"]); ?></td></tr>
                <tr><th>Occurrence Time</th><td><?php echo htmlspecialchars($row["occurence_time"]); ?></td></tr>
                <tr><th>Description</th><td><?php echo htmlspecialchars($row["description"]); ?></td></tr>
                <tr><th>Status</th><td><?php echo htmlspecialchars($row["status"]); ?></td></tr>
            </table>
        </div>
        <div class="pdf-actions">
            <button onclick="generatePDF()">Print/Download PDF</button>
        </div>
    </div>
    <script>
        function generatePDF() {
            const element = document.getElementById('pdf-content');
            const opt = {
                margin:       0.5,
                filename:     'user_case_details.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>
</html>
