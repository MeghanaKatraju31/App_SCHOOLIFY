<?php
include_once('functions.php');
if (isset($_POST['submit_instructor'])) {
    if (submitInstructor()) {
        echo '<script>alert("Instructor Added Succesfully!")</script>';
    } else {
        echo '<script>alert("Failed!")</script>';
    }
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/adminheader.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Student Profile</title>
    <script>
        function validateForm() {
            const name = document.getElementById('name').value;
            const department = document.getElementById('department').value;
            const email = document.getElementById('email').value;
            const phoneNumber = document.getElementById('phone_no').value;
            const fatherName = document.getElementById('father_name').value;
            const password = document.getElementById('password').value;
            const idNumber = document.getElementById('identity_no').value;
            const empId = document.getElementById('empId').value;
            const program = document.getElementById('program').value;
            const designation = document.getElementById('designation').value;
            const fileImage = document.getElementById('file-image')
            if (fileImage.files.length === 0 || !name || !department || !email || !phoneNumber || !fatherName || !password || !idNumber || !empId || !designation || !program) {
                alert('Please fill in all the required fields.');
                return false;
            }
            if (fileImage.files.length === 0) {
                alert('Please upload your photo.');
                return false;
            }
            if (!isValidName(name)) {
                alert('Name should not contain special characters.');
                return false;
            }
            if (!isValidName(fatherName)) {
                alert('Father Name should not contain special characters.');
                return false;
            }
            if (!isValidName(department)) {
                alert('Department should not contain special characters.');
                return false;
            }
            if (!isValidName(program)) {
                alert('Program should not contain special characters.');
                return false;
            }
            if (!isValidName(designation)) {
                alert('Designation should not contain special characters.');
                return false;
            }
            if (!isValidEmail(email)) {
                alert('Please enter a valid email address.');
                return false;
            }
            if (!isValidPhoneNumber(phoneNumber)) {
                alert('Please enter a valid phone number.');
                return false;
            }
            if (!isValidPassword(password)) {
                alert('Password should be at least 6 characters long.');
                return false;
            }
            return true;
        }

        function isValidName(name) {
            const nameRegex = /^[A-Za-z\s]+$/;
            return nameRegex.test(name);
        }
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhoneNumber(phoneNumber) {
            const phoneRegex = /^\d+$/;
            return phoneRegex.test(phoneNumber);
        }

        function isValidPassword(password) {
            return password.length >= 3;
        }
    </script>
</head>

<body>
    <header id="schoolify-header">
        <nav>
            <input type="checkbox" id="check" style="color: transparent">
            <label for="check" class="checkbtn">
                <div class="hamber">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </label>
            <label class="logo">Schoolify</label>
            <ul>
                <li><a href="adminportal.php">Home</a></li>
                <li><a href="adminstudentpage.php">Student</a></li>
                <li><a class="active" href="adminInstructorPage.php">Instructor</a></li>
                <li><a href="adminProgramcopage.php">Program Coordinator</a></li>
                <li><a href="adminQApage.php">QA Officer</a></li>
                <li>
                    <a href="#">
                        <i class="fas fa-bell"></i>
                        <div class="notification-popup">
                            <p>No notifications yet</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-user"></i></a>
                    <ul class="dropdown">
                        <li><a href="adminprofile.php">Profile</a></li>
                        <li><a href="home.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <section></section>
    </header>
    <!--PROFILE-->
    <div class="profile-card">
        <div class="profile-image">
            <img src="./images/imageicon.png" id="profile-img" alt="Profile Image">
        </div>
        <div class="profile-info">
            <form enctype="multipart/form-data" method="POST" onsubmit="return validateForm()">
                <input type="file" id="file-image" name="image" hidden />
                <div class="profile-details">
                    <!-- Row 1: Registration No, Identity No, Father's Name -->
                    <div class="detail-row">
                        <div class="detail-item">
                            <label for="name"><i class="fas fa-user-friends"></i> Name:</label>
                            <input type="text" id="name" placeholder="Instructor Name" name="name" autofocus>
                        </div>
                        <div class="detail-item">
                            <label for="department"><i class="fas fa-building"></i> Department:</label>
                            <input type="text" id="department" placeholder="Your Department" name="department">
                        </div>
                        <div class="detail-item">
                            <label for="phone_no"><i class="fas fa-phone"></i> Phone No:</label>
                            <input type="text" id="phone_no" placeholder="Your Phone No" name="phoneNumber">
                        </div>
                        <div class="detail-item">
                            <label for="designation"><i class="fa-solid fa-shield"></i> Designation:</label>
                            <input type="text" id="designation" placeholder="Your Designation" name="designation">
                        </div>
                    </div>

                    <!-- Row 2: Program, Semester -->
                    <div class="detail-row">
                        <div class="detail-item">
                            <label for="father_name"><i class="fas fa-user-friends"></i> Father's Name:</label>
                            <input type="text" id="father_name" placeholder="Father's Name" name="fatherName" autofocus>
                        </div>
                        <div class="detail-item">
                            <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                            <input type="email" id="email" placeholder="yourname@example.com" name="email">
                        </div>
                        <div class="detail-item">
                            <label for="identity_no"><i class="fas fa-id-card"></i> Identity No:</label>
                            <input type="text" id="identity_no" placeholder="Your Identity No" name="idNumber">
                        </div>
                    </div>

                    <!-- Row 3: Email, Phone No -->
                    <div class="detail-row">
                        <div class="detail-item">
                            <label for="registration_no"><i class="fas fa-id-card"></i> Employee ID:</label>
                            <input type="text" id="empId" placeholder="Your Employee ID" name="empId">
                        </div>
                        <div class="detail-item">
                            <label for="password"><i class="fas fa-lock"></i> Password:</label>
                            <input type="password" id="password" placeholder="Password" name="password">
                        </div>

                        <div class="detail-item">
                            <label for="program"><i class="fa-solid fa-circle-info"></i> Program:</label>
                            <input type="text" id="program" placeholder="Your program" name="program">
                        </div>
                    </div>
                </div>
                <button class="edit-button" name="submit_instructor" type="submit">Create</button>
            </form>
        </div>
    </div>
    <footer>
        <div class="content">
            <div class="left-box">
                <label for="logo" class="logo">Schoolify</label>
            </div>
            <div class="right-box">Contact Us
                <ul>
                    <li>Email:something@something.com</li>
                    <li>Tel No.:+34-354343</li>
                </ul>
            </div>
        </div>
        <hr class="Break">
        <br>
        <div class="middle-box">
            <ul>
                <li><a class="active" href="adminportal.php">Home</a></li>
                <li><a href="adminstudentpage.php">Student</a></li>
                <li><a href="adminInstructorPage.php">Instructor</a></li>
                <li><a href="adminProgramcopage.php">Program Coordinator</a></li>
                <li><a href="adminQApage.php">QA Officer</a></li>
                <li><a href="adminprofile.php">Profile</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </div>
        <br>
        <div class="bottom">
            <p>Copyright © Schoolify Inc., All rights reserved.</p>
        </div>
        </div>

    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Replace the URL inside the attr() method with the desired image URL
            $('#file-image').on('change', function(e) {
                // Get the selected file from the input
                var file = e.target.files[0];

                // Check if a file was selected
                if (file) {
                    // Create a FileReader object
                    var reader = new FileReader();

                    // Set the onload event of the FileReader
                    reader.onload = function(e) {
                        // Get the result (base64 encoded image data)
                        var imageUrl = e.target.result;

                        // Set the 'src' attribute of the image to the base64 data
                        $('#profile-img').attr('src', imageUrl);
                    };

                    // Read the file as a data URL (base64 encoded image data)
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <script>
        const profileImage = document.getElementById('profile-img')
        const fileImage = document.getElementById('file-image')
        fileImage.addEventListener('change', function () {
            profileImage.src = './images/uploaded.png'
        });
        profileImage.addEventListener('click', function () {
            fileImage.click()

        });
    </script>
</body>

</html>