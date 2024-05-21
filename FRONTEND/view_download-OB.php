<?php
// Start the session
include './constants/authenticator.php';

// Include the database connection file
include '../Database/db_con.php';

// Check if the user is logged in and if an ID is provided in the URL
if (isset($_SESSION['email'])) {
    // Fetch user details from the database using the session email
    $email = $_SESSION['email'];

    // Fetch user details from the database using the session email
    $sql = "SELECT * FROM verified WHERE email = '" . $conn->real_escape_string($email) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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
                        <tr><th>ID Number</th><td><?php echo htmlspecialchars($row["id_number"]); ?></td></tr>
                        <tr><th>Mobile Number</th><td><?php echo htmlspecialchars($row["mobile_no"]); ?></td></tr>
                        <tr><th>Location</th><td><?php echo htmlspecialchars($row["location"]); ?></td></tr>
                        <tr><th>Occurrence Date</th><td><?php echo htmlspecialchars($row["occurence_date"]); ?></td></tr>
                        <tr><th>Occurrence Time</th><td><?php echo htmlspecialchars($row["occurence_time"]); ?></td></tr>
                        <tr><th>ID Upload</th>
                            <td><a href="../FRONTEND/<?php echo htmlspecialchars($row['id_upload']); ?>" target="_blank">
                                <img src="../FRONTEND/<?php echo htmlspecialchars($row['id_upload']); ?>" alt="ID Upload" width="100">
                            </a></td>
                        </tr>
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
                    // New Promise-based usage:
                    html2pdf().from(element).set(opt).save();
                }
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "No reported cases found or you do not have permission to view this case.";
    }
} else {
    // If the user is not logged in or no ID is provided, redirect them to the login page or display a message
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

$conn->close();
?>
