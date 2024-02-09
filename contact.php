<?php
include_once('functions.php');
include_once('header.php'); 
if(isset($_POST['submit_contact'])) {
	submit_contact();
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/services.css">
    <link rel="stylesheet" type="text/css" href="css/contact.css">
    <title>Document</title>
    <script type="text/javascript">
        function validateForm() {
            // Get form values
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var question = document.getElementById("question").value;

            // Validate name (only alphabets and spaces)
            var nameRegex = /^[a-zA-Z\s]+$/;
            if (!nameRegex.test(name.trim())) {
                alert("Please enter a valid name (only alphabets and spaces).");
                return false;
            }

            // Validate email
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailRegex.test(email.trim())) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Validate question
            if (question.trim() === "") {
                alert("Please describe your issue.");
                return false;
            }

            // You can add more specific validations if needed

            return true;
        }
    </script>
</head>
<body>
      <!-- Contact Us Form -->
      <div class="contactus-container">
        <form class="contactus-form" onsubmit="return validateForm();" method="POST">
            <div class="contact-Intro">
                <h3>Contact Us</h3>
                <p>Reach us out in simple steps</p>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-with-icon">
                    <span class="icon">&#9993;</span> <!-- Email icon -->
                    <input type="email" id="email" name="email" class="email-input" placeholder="Enter your email"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <textarea type="text" id="question" name="question" class="question-input"
                    placeholder="Describe your Issue" required></textarea>
            </div>
            <div class="submit-button">
                <button type="submit" name="submit_contact">Submit</button>
    </div>
    </div>
</body>
</html>
<?php include_once('footer.php'); ?>
