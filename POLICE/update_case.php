<?php include '../Database/db_con.php'; ?>
<?php include 'CONSTANTS/sidebar_header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Records</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        h1 {
            text-align: center;
        }
        .search-box {
            text-align: center;
            padding: 50px;
            margin-bottom: 20px;
        }
        .search-box input[type="text"] {
            width: 300px;
            padding: 10px;
        }
        .search-box input[type="submit"] {
            padding: 10px 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }
        .pending {
            background-color: gray;
        }
        .under-investigation {
            background-color: orange;
        }
        .case-closed {
            background-color: red;
            cursor: not-allowed; /* Change cursor to indicate it's not clickable */
        }
        .fa-clock {
            margin-right: 5px;
        }
        .status-button[disabled] {
            cursor: not-allowed; /* Ensures the button shows as disabled */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Case Records</h1>
    <div class="search-box">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Enter ID Number" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <input type="submit" value="Search">
        </form>
    </div>

    <?php
    $search_query = "";
    if (isset($_GET['search']) && $_GET['search'] != "") {
        $search = $conn->real_escape_string($_GET['search']);
        $search_query = " WHERE id_number = '$search'";
    }

    $query = "SELECT name, id_number, mobile_no, location, occurence_date, description, status, ob_number, investigation_status, 
              IFNULL(case_status, 'Pending') AS case_status, email 
              FROM verified $search_query";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Mobile Number</th>
                    <th>Location</th>
                    <th>Occurence Date</th>
                    <th>Case Status</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            $status_class = strtolower(str_replace(' ', '-', $row['case_status']));
            $icon = $row['case_status'] == 'Pending' ? '<i class="fas fa-clock"></i>' : '';
            $disabled = $row['case_status'] == 'Case Closed' ? 'disabled' : '';
            $onclick = $row['case_status'] == 'Case Closed' ? '' : "onclick='confirmUpdateStatus(" . json_encode($row) . ")'";
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['id_number']}</td>
                    <td>{$row['mobile_no']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['occurence_date']}</td>
                    <td><button class='status-button $status_class' $onclick $disabled>{$icon} {$row['case_status']}</button></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found.</p>";
    }

    $conn->close();
    ?>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdateStatus(caseDetails) {
            let currentStatus = caseDetails.case_status;
            let newStatus = currentStatus === 'Pending' ? 'Under Investigation' : 'Case Closed';

            let caseInfo = `
                <p><strong>Name:</strong> ${caseDetails.name}</p>
                <p><strong>ID Number:</strong> ${caseDetails.id_number}</p>
                <p><strong>Mobile Number:</strong> ${caseDetails.mobile_no}</p>
                <p><strong>Location:</strong> ${caseDetails.location}</p>
                <p><strong>Occurence Date:</strong> ${caseDetails.occurence_date}</p>
                <p><strong>Description:</strong> ${caseDetails.description}</p>
                <p><strong>Current Status:</strong> ${caseDetails.case_status}</p>
            `;

            Swal.fire({
                title: 'Update Case Status',
                html: caseInfo + `
                    <textarea id="updateReason" rows="4" cols="50" placeholder="Enter reason for status update"></textarea>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const updateReason = Swal.getPopup().querySelector('#updateReason').value;
                    if (!updateReason) {
                        Swal.showValidationMessage(`Please enter a reason`);
                    }
                    return { updateReason: updateReason };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    sendUpdate(caseDetails, newStatus, result.value.updateReason);
                }
            });
        }

        function sendUpdate(caseDetails, newStatus, updateReason) {
            fetch('update_case_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ caseDetails: caseDetails, newStatus: newStatus, updateReason: updateReason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'The case status has been updated successfully and the user has been notified.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Refresh the page to show the updated status
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the case status.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>

</body>
</html>
