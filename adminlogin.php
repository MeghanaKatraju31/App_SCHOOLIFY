<?php
include_once('functions.php');

include_once('header.php');
if (isset($_POST['admin_login'])) {
    admin_login();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script type="text/javascript">
        function validateForm() {
    // Get form values
    var emp_id = document.getElementById("emp_id").value;
    var password = document.getElementById("password").value;

    // Validate registration number (you can customize the regex pattern)
    var regNoRegex = /^[a-zA-Z0-9]+$/;
    if (!regNoRegex.test(emp_id.trim())) {
        alert("Please enter a valid registration number.");
        return false;
    }


    // You can add more specific validations if needed

    return true;
}
    </script>
    <title>Document</title>
</head>
<body>
<div class="login-container">
        <form class="login-form" method="POST" onsubmit="return validateForm();">
            <div class="welcome">
                <h1 class="welcome-text">Welcome Back!</h1>
                <p style="margin-top: -10px;">Login below or Create Account</p>
            </div>

            <div class="form-group">
                <label for="username">Employee ID</label>
                <input type="text" id="emp_id" name="empl_id" placeholder="Type your Registration No" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-input">
                    <input type="password" id="password" name="password" placeholder="Type your password" required>
                    <span class="eye-icon">&#128065;</span>
                </div>
            </div>


            <div class="login-button">
                <button type="submit" name="admin_login">Sign In</button>
            </div>



        </form>
    </div>
</body>
</html>
<?php include_once('footer.php'); ?>
