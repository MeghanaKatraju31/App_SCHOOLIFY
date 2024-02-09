<?php
// Start or resume session
include_once('functions.php');
// Check if the user is logged in
if (!isset($_SESSION['instructor']))
{
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
if (isset($_POST['create_exam']))
{
    if (createExam()) {
        echo '<script>alert("Exam created  Succesfully!")</script>';
        header("Location: teacherexams.php");
        exit();

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
    <link rel="stylesheet" type="text/css" href="css/takeexam.css">
    <link rel="stylesheet" type="text/css" href="css/createexam.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Student Exams</title>
   
    <script>
        
function validateForm() {
    // Get the values of the exam title, time allotted, and questions
    var examTitle = document.getElementById("exam_title").value;
    var timeAllot = document.getElementById("time_alloted").value;
    var exam_desc = document.getElementById("exam_desc").value;
    // Validate exam title (only alphabets, spaces, numbers, commas, and periods are allowed)
    var regex = /^[a-zA-Z0-9\s.,?-]+$/;
    if (!regex.test(examTitle.trim())) {
        alert("Please enter a valid exam title (Only alphabets, spaces, numbers, commas, and periods).");
        return false;
    }
    if (!regex.test(exam_desc.trim())) {
        alert("Please enter a valid exam Desc(Only alphabets, spaces, numbers, commas, and periods).");
        return false;
    }

    // Check if time allotted is empty
    if (timeAllot.trim() === "") {
        alert("Time allotted cannot be empty");
        return false;
    }

    // Validate questions and their corresponding options
    var questionInputs = document.getElementsByClassName("question");
    for (var i = 0; i < questionInputs.length; i++) {
        var questionInput = questionInputs[i];
        var questionText = questionInput.value.trim();

        if (questionText === "") {
            alert("Please enter a valid question for Question " + (i + 1));
            return false;
        }

        var option1Input = document.getElementById("mcq" + (i + 1) + "_opt1");
        var option2Input = document.getElementById("mcq" + (i + 1) + "_option2");
        var option1Text = option1Input.value.trim();
        var option2Text = option2Input.value.trim();

        if (option1Text === "" || option2Text === "") {
            alert("Please fill in both options for Question " + (i + 1));
            return false;
        }
    }

    // All validations passed
    return true;
}
</script>

<style>
        .custom-select {
    background-color: #5295c2;
    color: white; /* text color */
    border-radius: 10px; /* adjust as needed */
    padding: 5px; /* adjust as needed */
    /* Add other styles as needed */
}

        </style>

</head>

<body>
<?php
 if (isset($_SESSION['instructor'])) {
     // Access the student's information
     $instructor = $_SESSION['instructor'];
     $teacher_id=$instructor['instructor_id'];
  $courses = get_teacher_courses($teacher_id);
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
                <li><a  href="teacherportal.php">Home</a></li>
                <li><a href="teachercourses.php">Courses</a></li>
                <li><a class="active" href="teacherexams.php">Exams</a></li>
                <li><a href="teacherresults.php">Results</a></li>
                <li class="hidethem"><a href="teacherprofile.php">Profile</a></li>
                <li class="hidethem"><a href="home.php">Logout</a></li>
            </ul>
        </nav>
        <section></section>
    </header>
    <form method="POST" onsubmit="return validateForm();">


    <section class="exam-info-section">
    <div class="exam-info">
        <div class="exam-info-heading">
            <input type="text" placeholder="Exam Title" name="exam_title" id="exam_title" autofocus>
        </div>
        <div class="exam-info-heading">
            <input type="text" placeholder="Exam Desc" name="exam_desc" id="exam_desc">
        </div>
        <div class="exam-info-heading">
            <input type="text" placeholder="time_alloted" name="time_alloted" id="time_alloted">
        </div>
        <div class="exam-info-heading">
            <select name="course_id" class="custom-select" id="exam_course" >
                <option value="">Select a Course</option>
                <?php
                foreach ($courses as $course) { 
                    $course_det = get_course_details($course);
                ?>
                <option required value="<?php echo $course_det['course_id']?>" style="color:blue;"><?php echo $course_det['course_title']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="time-remaining">
            <input type="date" placeholder="due_date" name="due_date" id="due_date" required>
        </div>
    </div>

    <div class="exam-mcqs">
        <?php for ($i = 1; $i <= 10; $i++) { ?>
            <div class="mcq">
    <div class="questionsdiv">
    <p><?php echo $i; ?>.</p>
        <input class="question" type="text" placeholder="Question" name="question[]" id="question<?php echo $i; ?>">
    </div>

    <div class="optionsdiv">
        <label for="mcq<?php echo $i; ?>_option1">
            <input type="text" class="option" placeholder="Option 1" name="option1[]" id="mcq<?php echo $i; ?>_opt1" >
        </label>
    </div>

    <div class="optionsdiv">
        <label for="mcq<?php echo $i; ?>_option2">
            <input type="text" class="option" placeholder="Option 2" name="option2[]" id="mcq<?php echo $i; ?>_option2">
        </label>
    </div>
    <div class="optionsdiv">
        <p>Choose correct option:</p>
        <label for="mcq<?php echo $i; ?>_correct_answer">
            <input type="radio" name="correctoption[<?php echo $i; ?>]" id="mcq<?php echo $i; ?>_correct_option1" value="c_option1" >Option 1
            <input type="radio" name="correctoption[<?php echo $i; ?>]" id="mcq<?php echo $i; ?>_correct_option2" value="c_option2" >Option 2
        </label>
    </div>
    
</div>
        <?php } ?>
    </div>
</section>

<input type="text" name="teacher_id" hidden  value="<?php echo $teacher_id;  ?>">

    <div class="create-button">
        <button type="submit"  name="create_exam">Create</button>
    </div>
</form>

    <!-- Footer -->
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
                <li><a href="teachercourses.php">Courses</a></li>
                <li><a href="teacherexams.php">Exams</a></li>
                <li><a href="teacherresults.php">Results</a></li>
                <li><a class="active" href="teacherprofile.php">Profile</a></li>
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