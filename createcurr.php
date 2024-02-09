<?php
include_once('functions.php');
// Check if the user is logged in
if (!isset($_SESSION['program_coordinator'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
$pc=$_SESSION['program_coordinator'];
$pc_id=$pc['program_co_id'];

if (isset($_POST['create_curr'])) {
    if (createCurr()) {
        echo '<script>alert("Curriculum Added Succesfully!")</script>';
        header('Location: createcurr.php');
    } else {
        echo '<script>alert("Failed!")</script>';
        header('Location: createcurr.php');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="css/portalheader.css">
    <link rel="stylesheet" type="text/css" href="css/imagewithtext.css">
    <link rel="stylesheet" type="text/css" href="css/teachercourses.css">
    <link rel="stylesheet" type="text/css" href="css/createrecomendation.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/programcocurriculumupdate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Program Curriculum Update</title>
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
                        <li><a href="programcoordinatorprofile.php">Profile</a></li>
                        <li><a href="home.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navmenu">
                <li><a  href="programcoordinatorportal.php" >Home</a></li>
                <li><a  href="programevaluation.php" >Program Evaluation</a></li>
                <li><a  href="curriculum.php" class="active" >Curriculum</a></li>
                <li class="hidethem"><a href="programcoordinatorprofile.php">Profile</a></li>
                <li class="hidethem"><a href="home.php">Logout</a></li>
              
            </ul>
        </nav>
        <section></section>
    </header>
    <div class="create-recomendation-form">
        <h2>Create Curriculum</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="crTitle">Curriculum Title:</label>
                    <input type="text" id="recommendationTitle" name="cr_title"
                      >
                </div>

                <div class="form-group">
                    <label for="CurriculumDescription">Curriculum Description:</label>
                    <textarea id="CurriculumDescription" name="cr_description" rows="8" cols="50"
                        ></textarea>
                </div>
                <input hidden type="text" name="pc_id" value="<?php echo $pc_id?>">
                <button class="create-button update" type="submit" name="create_curr">Create</button>
            </form>
    </div>
<a class="myBtn" href="prpgramcoordinatorchat.php">
    <span class="icon"></span>
    Chat
  </a>
</body>
</html>
<?php 
include_once('programcofooter.php'); ?>