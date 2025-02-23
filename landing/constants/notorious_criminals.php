<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notorious Criminals</title>

    <style>

            /* Styling for the notorious criminals section */
    .notorious-criminals {
        margin-top: 20px;
        text-align: center;
    }
    .notorious-criminals h2 {
        margin-bottom: 20px;
    }
    .scroll-container {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding: 20px;
        background-color: #f4f4f4;
    }
    .criminal-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        text-align: left;
        flex: 0 0 auto;
        width: 200px; /* Fixed width to control the size of each card */
    }
    .criminal-card img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }
    .criminal-card h3 {
        margin-top: 10px;
        margin-bottom: 5px;
        font-size: 1.2em;
    }
    .criminal-card p {
        margin: 0;
        color: #555;
    }

    </style>
</head>
<body>
    <?php
    // Include the database connection
    $db_con_path = __DIR__ . '/../../Database/db_con.php';

    if (file_exists($db_con_path)) {
        include $db_con_path;

        // Fetch notorious criminals from the database
        $query = "SELECT * FROM criminals";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="criminal-card">';
                if ($row['image']) {
                    $image_path = '/ICMSSYSTEM/POLICE/criminal-uploads/' . htmlspecialchars($row['image']);
                    echo '<img src="' . $image_path . '" alt="Criminal Image">';
                }
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>Crime: ' . htmlspecialchars($row['crime']) . '</p>';
                echo '<p>Sentence: ' . htmlspecialchars($row['sentence']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No notorious criminals found.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo '<p>Error: Could not load the database connection file.</p>';
    }
    ?>
</body>
</html>
