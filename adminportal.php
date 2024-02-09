<?php
include_once('functions.php');
// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
$instructors = getInstructors();
$students = getStudents();
$programCos = getProgramCos();
$qas = getQAs();
$numberOfInstructors = mysqli_num_rows($instructors);
$numberOfStudents = mysqli_num_rows($students);
$numberOfcourses = get_n_courses();
$numberOfPr = mysqli_num_rows($programCos);
$numberOfQA = mysqli_num_rows($qas);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/adminheader.css">
    <link rel="stylesheet" type="text/css" href="css/imagewithtext.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/chatbtn.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Admin Portal</title>
</head>

<body>
<?php
 if (isset($_SESSION['admin'])) {
     // Access the student's information
     $admin = $_SESSION['admin'];
 
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
            <ul>
                <li><a href="adminportal.php" class="active">Home</a></li>
                <li><a href="adminstudentpage.php" >Student</a></li>
                <li><a href="adminInstructorPage.php">Instructor</a></li>
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
                    <a  href="#"><i class="fas fa-user"></i></a>
                    <ul class="dropdown">
                        <li><a href="adminprofile.php">Profile</a></li>
                        <li><a href="home.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <section></section>
    </header>
    <div class="image-with-text">
        <div class="overlay"></div>
        <img src="./images/bg1.jpeg" alt="University Image">
        <div class="image-text-container">
        <h2 class="image-text">HELLO <span style="text-transform: capitalize;"><?php echo $admin['admin_name']; ?></span></h2>
            <h2 class="image-text">WELCOME TO ADMIN PORTAL!</h2>
        </div>
    </div>

    <div class="feature-container">
        <a href="adminstudentpage.php" class="feature-box">
            <div class="feature-text">Student</div>
            <img src="./images/student.webp" alt="Student Courses">
        </a>


        <a href="adminProgramcopage.php" class="feature-box">
            <div class="feature-text">Program Coordinator</div>
            <img src="./images/programcoordinator.jpg" alt="Program Coordinator Courses">
        </a>
        <a href="adminInstructorPage.php" class="feature-box">
            <div class="feature-text">Instructor</div>
            <img src="./images/instructor.jpg" alt="Instructor Courses">
        </a>

        <a href="adminQApage.php" class="feature-box">
            <div class="feature-text">QA Officer</div>
            <img src="./images/QA.jpg" alt="QA Officer Courses">
        </a>

    </div>
    <div class="statistics">
        <div class="icon-box">

            <div class="text">
                <i class="fas fa-user"></i>
                <h2>Students</h2>
            </div>
            <p><?php echo $numberOfStudents?></p>
        </div>

        <div class="icon-box">

            <div class="text">
                <i class="fas fa-chalkboard-teacher"></i>
                <h2>Instructors</h2>

            </div>
            <p><?php echo $numberOfInstructors?></p>
        </div>
        <div class="icon-box">

            <div class="text">
                <i class="fas fa-chalkboard-teacher"></i>
                <h2>Program Coordinators</h2>

            </div>
            <p><?php echo $numberOfPr?></p>
        </div>
        
        <div class="icon-box">

<div class="text">
    <i class="fas fa-chalkboard-teacher"></i>
    <h2>Quality Assurance Officer</h2>

</div>
<p><?php echo $numberOfQA?></p>
</div>
        <div class="icon-box">

            <div class="text">
                <i class="fas fa-book"></i>
                <h2>Courses</h2>

            </div>
            <p><?php echo $numberOfcourses?></p>
        </div>
        
      
    </div>
    <div class="user-activity">
    <h1 class="title">User Activities</h1>
    <table class="activity-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Role</th>
                <th>Action</th>
                <th>time_stamp</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch student activities
            $studentActivities = get_student_activities();
            foreach ($studentActivities as $activity) {
                echo "<tr>";
                echo "<td>{$activity['std_id']}</td>";
                echo "<td>Student</td>";
                echo "<td>{$activity['std_activity']}</td>";
                echo "<td>{$activity['time_stamp']}</td>";
                echo "</tr>";
            }

            // Fetch instructor activities
            $instructorActivities = get_instructor_activities();
            foreach ($instructorActivities as $activity) {
                echo "<tr>";
                echo "<td>{$activity['ins_id']}</td>";
                echo "<td>Instructor</td>";
                echo "<td>{$activity['ins_activity']}</td>";
                echo "<td>{$activity['time_stamp']}</td>";
                echo "</tr>";
            }

            // Fetch QA activities
            $qaActivities = get_qa_activities();
            foreach ($qaActivities as $activity) {
                echo "<tr>";
                echo "<td>{$activity['qa_id']}</td>";
                echo "<td>QA</td>";
                echo "<td>{$activity['qa_activity']}</td>";
                echo "<td>{$activity['time_stamp']}</td>";
                echo "</tr>";
            }

            // Fetch PC activities
            $pcActivities = get_pc_activities();
            foreach ($pcActivities as $activity) {
                echo "<tr>";
                echo "<td>{$activity['pc_id']}</td>";
                echo "<td>PC</td>";
                echo "<td>{$activity['pc_activity']}</td>";
                echo "<td>{$activity['time_stamp']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


 




    <a class="myBtn" href="adminchat.php">
        <span class="icon"></span>
        Chat
    </a>

 
    <script src="script.js"></script>
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
</body>

</html>
<?php 
