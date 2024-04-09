<!DOCTYPE html>
<html>
<head>
    <title>Report Case Form</title>
    <link rel="stylesheet" href="css/report.css">
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/ICMSSYSTEM/FRONTEND/constants/homeheader.php"; ?>

<main>
<h2>Report Case</h2>

<form method="post" enctype="multipart/form-data">
    Phone Number: <input type="text" name="phone_number" required><br><br>
    Location: <input type="text" name="location" required><br><br>
    Date of Occurrence: <input type="date" name="occurrence_date" required><br><br>
    Time of Occurrence: <input type="time" name="occurrence_time" required><br><br>
    ID Number: <input type="text" name="id_number" required><br><br>
    Description: <textarea name="description" required></textarea><br><br>
    Upload ID: <input type="file" name="id_upload" id="id_upload" required><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php handleFormSubmission(); ?>
</main>

<!-- Add footer content here -->

</body>
</html>
