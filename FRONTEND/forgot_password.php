<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>
    <div class="container">
        <h1>Forgot Password?</h1>
        <p>Please enter your email or phone number.</p>
        <p>An email or SMS with a new password will be sent to you.</p>
        <form action="#">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="phone">Mobile Number</label>
                <input type="tel" name="phone" id="phone">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
