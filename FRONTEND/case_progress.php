<?php
// Start the session
include './constants/authenticator.php';
include './constants/navigation.php';
include '../Database/db_con.php';

// Check if the user is logged in (i.e., if their session is set)
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Properly quote the email address in the SQL query
    $sql = "SELECT * FROM verified WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/track_case.css">
            <title>User Case Details</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                h2 {
                    text-align: center;
                }
                table {
                    width: 80%;
                    margin: 20px auto;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 10px;
                    border: 1px solid #ccc;
                }
                th {
                    background-color: #f2f2f2;
                    text-align: left;
                }
                img {
                    width: 100px;
                    height: 100px;
                    object-fit: contain;
                    cursor: pointer;
                }
                .status {
                    display: inline-block;
                    padding: 8px 16px;
                    color: white;
                    border-radius: 4px;
                }
                .status-pending {
                    background-color: #f0ad4e;
                }
                .status-investigation {
                    background-color: #5bc0de;
                }
                .status-closed {
                    background-color: #d9534f;
                }
                .popup-link {
                    color: #007bff;
                    text-decoration: underline;
                    cursor: pointer;
                }
                /* Styles for the pop-up modal */
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1;
                    padding-top: 100px;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgb(0,0,0);
                    background-color: rgba(0,0,0,0.4);
                }
                .modal-content {
                    background-color: #fefefe;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                }
                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }
                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
                /* Styles for navigation buttons */
                .nav-buttons {
                    display: flex;
                    justify-content: center;
                    margin: 20px;
                }
                .nav-buttons button {
                    padding: 10px 20px;
                    font-size: 16px;
                    cursor: pointer;
                    border: none;
                    color: white;
                    border-radius: 5px;
                    margin: 0 10px;
                    transition: background-color 0.3s;
                }
                .prev-button {
                    background-color: #007BFF; /* Blue */
                }
                .next-button {
                    background-color: #28A745; /* Green */
                }
                .nav-buttons button:hover {
                    opacity: 0.8;
                }

                .popup-link {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #007bff; /* Blue */
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    text-align: center;
}

.popup-link:hover {
    background-color: #0056b3; /* Darker blue */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

            </style>
        </head>
        <body>
            <!-- Include navigation buttons here -->
           <!-- ?php include './constants/navigation.php'; ?>-->

            <div class="container">
                <div class="form-container">
                    <h2>User Case Details</h2>
                    <table>
                        <tr>
                            <th>Location</th>
                            <th>Occurrence Date</th>
                            <th>Occurrence Time</th>
                            <th>ID Upload</th>
                            <th>Description</th>
                            <th>OB Number</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $status = "Pending";
                            $status_class = "status-pending";
                            if ($row["case_status"] === "Under Investigation") {
                                $status = "Under Investigation";
                                $status_class = "status-investigation";
                            } elseif ($row["case_status"] === "Case Closed") {
                                $status = "Case Closed";
                                $status_class = "status-closed";
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["location"]); ?></td>
                                <td><?php echo htmlspecialchars($row["occurence_date"]); ?></td>
                                <td><?php echo htmlspecialchars($row["occurence_time"]); ?></td>
                                <td><a href="../FRONTEND/<?php echo htmlspecialchars($row['id_upload']); ?>" target="_blank">
                                    <img src="../FRONTEND/<?php echo htmlspecialchars($row['id_upload']); ?>" alt="ID Upload">
                                </a></td>
                                <td><?php echo htmlspecialchars($row["description"]); ?></td>
                                <td><?php echo htmlspecialchars($row["ob_number"]); ?></td>
                                <td>
                                    <span class="status <?php echo $status_class; ?>"><?php echo $status; ?></span>
                                    <span class="popup-link" onclick="openModal('<?php echo htmlspecialchars(json_encode($row)); ?>')">View Details</span>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>

            <!-- The Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Case Details</h2>
                    <div id="caseDetailsContent"></div>
                </div>
            </div>

            <script>
                function openModal(caseData) {
                    var data = JSON.parse(caseData);
                    var content = `
                        <p><strong>Location:</strong> ${data.location}</p>
                        <p><strong>Occurrence Date:</strong> ${data.occurence_date}</p>
                        <p><strong>Occurrence Time:</strong> ${data.occurence_time}</p>
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>OB Number:</strong> ${data.ob_number}</p>
                        <p><strong>Investigation Status:</strong> ${data.investigation_status}</p>
                        <p><strong>Case Status:</strong> ${data.case_status}</p>
                    `;
                    document.getElementById('caseDetailsContent').innerHTML = content;
                    document.getElementById('myModal').style.display = "block";
                }

                // Get the modal
                var modal = document.getElementById("myModal");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "No reported cases found";
    }
} else {
    // If the user is not logged in, redirect them to the login page or display a message
    header("Location: login.php");
    exit();
}

$conn->close();
?>
