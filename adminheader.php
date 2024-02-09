<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/adminheader.css">
    <title>Document</title>
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
                <li><a href="adminportal.php" class="<?php echo ($activePage === 'home') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="adminstudentpage.php" class="<?php echo ($activePage === 'student') ? 'active' : ''; ?>">Student</a></li>
                <li><a href="adminInstructorPage.php" class="<?php echo ($activePage === 'instructor') ? 'active' : ''; ?>">Instructor</a></li>
                <li><a href="adminProgramcopage.php" class="<?php echo ($activePage === 'programco') ? 'active' : ''; ?>">Program Coordinator</a></li>
                <li><a href="adminQApage.php" class="<?php echo ($activePage === 'qa') ? 'active' : ''; ?>">QA Officer</a></li>
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
</body>
</html>