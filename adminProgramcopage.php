<?php
include_once('functions.php');
$programCos = getProgramCos();
if (isset($_POST['delete_program_co'])) {
    if (deleteProgramCo()) {
        echo '<script>alert("Program Coordinator Deleted Succesfully!")</script>';
        header('location:adminProgramcopage.php');
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
    <link rel="stylesheet" type="text/css" href="css/adminheader.css">
    <link rel="stylesheet" type="text/css" href="css/imagewithtext.css">
    <link rel="stylesheet" type="text/css" href="css/adminpage.css">
    <link rel="stylesheet" type="text/css" href="css/chatbtn.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Monitor Program Coordinator</title>
    <script>
        function completeDeletion() {
            const response = confirm('Are you sure you want to delete this program coordinator?')
            if (response) {
                return true
            } else {
                return false
            }
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
                <li><a href="adminInstructorPage.php">Instructor</a></li>
                <li><a href="adminProgramcopage.php" class="active">Program Coordinator</a></li>
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
            <h1 class="image-text">Program Coordinators</h1>
        </div>
    </div>
    <a href="createprogramco.php" class="create-course-button">Add New Coordinator</a>

    <!---EXAMS-->
    <div class="role-information">
        <h6>PROGRAM COORDINATORS</h6>
        <?php
        if ($programCos == false) {
            ?>
            <h6>No program coordinators data found.</h6>
            <?php
        } else {
            ?>
            <div class="responsivetable">
                <table class="role-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th colspan="5">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($programCos)) {
                            $program_co_id = $row['program_co_id'];
                            $program_co_name = $row['program_co_name'];
                            $employee_id = $row['employee_id'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $program_co_name ?>
                                </td>
                                <td>
                                    <?php echo $employee_id ?>
                                </td>
                                <td>
                                    <a href="viewprogramco.php?program_co_id=<?php echo $program_co_id; ?>"
                                        class="action-button view">View</a>
                                </td>
                                <td>
                                    <a href="updateprogramco.php?program_co_id=<?php echo $program_co_id; ?>"
                                        class="action-button update">Update</a>
                                </td>
                                <td>
                                    <form method="POST" onsubmit="return completeDeletion()">
                                        <input type="text" name="program_co_id" hidden value="<?php echo $program_co_id; ?>" />
                                        <button type="submit" class="action-button delete"
                                            name="delete_program_co">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="programcopermissions.php?program_co_id=<?php echo $program_co_id; ?>" class="action-button permission">Permissions</a>
                                </td>
                                <td>
                                    <a href="programcoactivities.php?program_co_id=<?php echo $program_co_id; ?>" class="action-button monitor">Monitor</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>

    <a class="myBtn" href="adminchat.php">
        <span class="icon"></span>
        Chat
    </a>
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
