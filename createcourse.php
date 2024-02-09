<?php
// Start or resume session
include_once('functions.php');
// Check if the user is logged in
if (!isset($_SESSION['instructor'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
if (isset($_POST['create_course'])) {
    if (createCourse()) {
        echo '<script>alert("Course created  Succesfully!")</script>';
    } else {
        echo '<script>alert("Failed!")</script>';
    }
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/portalheader.css">
    <link rel="stylesheet" type="text/css" href="css/createcourse.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Teacher courses</title>
    <script type="text/javascript">
    function validateForm() {
        var courseName = document.getElementById("courseName").value;
        var courseDescription = document.getElementById("courseDescription").value;

        // Validate registration number (you can customize the regex pattern)
        var regex = /^[a-zA-Z\s.,"]+$/;

        // Validate courseName and classDuration
        if (!regex.test(courseName.trim())) {
            alert("Please enter a valid course name (Only alphabets and spaces).");
            return false;
        }

        if (courseDescription.trim() === "") {
            alert("Please enter a course description.");
            return false;
        }


        // Validate content title and content description
        var contentTitles = document.getElementsByName("contentTitle");
        var contentDescriptions = document.getElementsByName("contentDescription");

        for (var i = 0; i < contentTitles.length; i++) {
            var contentTitle = contentTitles[i].value;
            var contentDescription = contentDescriptions[i].value;

            if (!regex.test(contentTitle.trim())) {
                alert("Please enter a valid content title for item " + (i + 1) + ".");
                return false;
            }

            if (!regex.test(contentDescription.trim())) {
                alert("Please enter a valid content description for item " + (i + 1) + ".");
                return false;
            }
        }
        
        // All validations passed
        return true;
    }
    document.addEventListener("DOMContentLoaded", function () {
    const addContentButton = document.getElementById("addContentSection");
    const container = document.getElementById("content-sections-container");

    addContentButton.addEventListener("click", function () {
        const contentSection = container.querySelector(".content-section");
        const newContentSection = contentSection.cloneNode(true);

        // Clear the input fields in the cloned section
        newContentSection.querySelector("input[name='contentTitle[]']").value = "";
        newContentSection.querySelector("textarea[name='contentDescription[]']").value = "";

        // Attach a click event listener to the "Remove" button in the new section
        const removeButton = newContentSection.querySelector(".remove-content-section");
        removeButton.addEventListener("click", function () {
            container.removeChild(newContentSection);
        });

        container.appendChild(newContentSection);
    });

    // Attach a click event listener to the "Remove" button in the initial content section
    const removeButtons = document.querySelectorAll(".remove-content-section");
    removeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            container.removeChild(button.parentElement);
        });
    });
});
    
</script>
<style>
    .add-remove-button{
        display: flex;
        justify-content: space-between;
        text-align:center;
    }

    .add-remove-button{
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
    .add-button{
        background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin: 0 auto; /* Center horizontally */
    display: block; 
    margin-top:50px
    }
</style>


</head>

<body>
<?php
 if (isset($_SESSION['instructor'])) {
     // Access the student's information
     $instructor = $_SESSION['instructor'];
     $teacher_id=$instructor['instructor_id'];
 
 } 
 ?>
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
            <ul class="iconsnav">
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
                        <li><a href="teacherprofile.php">Profile</a></li>
                        <li><a href="home.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navmenu">
                <li><a href="teacherportal.php">Home</a></li>
                <li><a  class="active" href="teachercourses.php">Courses</a></li>
                <li><a href="teacherexams.php">Exams</a></li>
                <li><a href="teacherresults.php">Results</a></li>
                <li class="hidethem"><a href="teacherprofile.php">Profile</a></li>
                <li class="hidethem"><a href="home.php">Logout</a></li>
            </ul>
        </nav>
        <section></section>
    </header>
    <!--CREATE COURSES-->
    <form  method="POST" onsubmit="return validateForm();" enctype="multipart/form-data">
    <div class="create-course-form">
        <h2>Create Course</h2>
     
            <div class="form-row">
                <div class="form-group">
                    <label for="courseName">Course Name:</label>
                    <input type="text" id="courseName" name="courseName" placeholder="Enter course name" required>
                </div>
                <div class="form-group">
                    <label for="courseCredits">Credits:</label>
                    <input type="number" id="courseCredits" name="courseCredits" placeholder="Enter course credits"
                        required min="1" max="4">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="courseDescription">Course Description:</label>
                    <textarea id="courseDescription" name="courseDescription" placeholder="Enter course description"
                        required></textarea>
                </div>
                <div class="form-group">
                    <label for="courseHours">Class Hours:</label>
                    <input type="number" id="courseHours" name="courseHours" placeholder="Enter class hours" required min="1" max="3">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="classesPerWeek">Classes per Week:</label>
                    <input type="number" id="classesPerWeek" name="classesPerWeek" placeholder="Enter classes per week"
                        required min="1" max="3">
                </div>
                <div class="form-group">
                    <label for="classDuration">Class Duration:</label>
                    <input type="text" id="classDuration" name="classDuration" placeholder="Enter class duration"
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="courseImage">Course Image:</label>
                    <input type="file" id="courseImage" name="course_image"">
                </div>
            </div>
</div>
<button type="button" id="addContentSection" class="add-button">Add New Course Content</button>

<div id="content-sections-container">
    <!-- Initial content section -->
    <div class="create-course-form content-section">
        <div class="form-row">
            <div class="form-group">
                <label for="contentTitle[]">Content Title:</label>
                <input type="text" name="contentTitle[]" placeholder="Enter content title" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="contentDescription[]">Content Description:</label>
                <textarea name="contentDescription[]" placeholder="Enter content description" required></textarea>
            </div>
        </div>
        <button type="button" class="remove-content-section add-remove-button">Remove</button>
    </div>
</div>


<input type="text" hidden name="teacher_id" value=<?php echo $teacher_id ?>>




<button class="create-button update" name="create_course" type="submit">Create</button>
</form>
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
                <li><a href="teacherportal.php">Home</a></li>
                <li><a class="active" href="teachercourses.php">Courses</a></li>
                <li><a href="teacherexams.php">Exams</a></li>
                <li><a href="teacherresults.php">Results</a></li>
                <li><a href="teacherprofile.php">Profile</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </div>
        <br>
        <div class="bottom">
            <p>Copyright © Schoolify Inc., All rights reserved.</p>
        </div>
        </div>

    </footer>
</body>

</html>