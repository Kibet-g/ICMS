<?php include '../Database/db_con.php'; ?>
<?php include 'constants/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Records</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        .verified {
            background-color: green;
        }
        .declined {
            background-color: red;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
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
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 5px 15px rgba(0,0,0,.5);
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
        .escalate-button {
            background-color: #ff9800;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

    $query = "SELECT 'declined' AS table_name, name, id_number, mobile_no, location, occurence_date, description, status, 'Declined' AS status_text 
              FROM declined $search_query
              UNION ALL
              SELECT 'verified' AS table_name, name, id_number, mobile_no, location, occurence_date, description, status, 'Verified' AS status_text 
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
                    <th>Status</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            $status_class = $row['table_name'] == 'verified' ? 'verified' : 'declined';
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['id_number']}</td>
                    <td>{$row['mobile_no']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['occurence_date']}</td>
                    <td><button class='status-button $status_class' onclick='showDetails(".json_encode($row).")'>{$row['status_text']}</button></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found.</p>";
    }

    $conn->close();
    ?>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="case-details"></div>
            <button class="escalate-button" onclick="escalateCase()">Escalate Case</button>
        </div>
    </div>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showDetails(caseDetails) {
            const modal = document.getElementById("myModal");
            const caseDetailsDiv = document.getElementById("case-details");
            caseDetailsDiv.innerHTML = `
                <p><strong>Name:</strong> ${caseDetails.name}</p>
                <p><strong>ID Number:</strong> ${caseDetails.id_number}</p>
                <p><strong>Mobile Number:</strong> ${caseDetails.mobile_no}</p>
                <p><strong>Location:</strong> ${caseDetails.location}</p>
                <p><strong>Occurence Date:</strong> ${caseDetails.occurence_date}</p>
                <p><strong>Description:</strong> ${caseDetails.description}</p>
                <p><strong>Status:</strong> ${caseDetails.status_text}</p>
            `;
            modal.style.display = "block";
        }

        function closeModal() {
            const modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        function escalateCase() {
            Swal.fire({
                title: 'Case Escalated!',
                text: 'The case has been escalated successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    closeModal();
                }
            });
        }

        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
