<?php
include_once('functions.php');
if (isset($_POST['submit_recommendation'])) {
    if (submitRecommendation()) {
        echo '<script>alert("Recommendations Added Succesfully!")</script>';
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
    <link rel="stylesheet" type="text/css" href="css/createrecomendation.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Create Recommendation</title>

</head>

<body>
<?php 
if (isset($_SESSION['qa_officer'])) {
    // Access the student's information
    $qa = $_SESSION['qa_officer'];}
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
                        <li><a href="qaofficerprofile.php">Profile</a></li>
                        <li><a href="home.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navmenu">
                <li><a href="qaofficerportal.php">Home</a></li>
                <li><a href="qapolicies.php">POLICIES</a></li>
                <li><a class="active" href="qarecomendations.php">RECOMENDATIONS</a></li>
                <li><a href="studentperformance.php">STUDENT PERFORMANCE</a></li>
                <li class="hidethem"><a href="qaofficerprofile.php">Profile</a></li>
                <li class="hidethem"><a href="home.php">Logout</a></li>

            </ul>
        </nav>
        <section></section>
    </header>

    <div class="create-recomendation-form">
        <h2>Create New Recommendation</h2>
        <form method="POST">
        <input hidden type="text" name="qa_id" value="<?php echo $qa['qa_id']?>">
            <div class="form-group">
                <label for="recommendationTitle">Recommendation Title:</label>
                <input type="text" id="recommendationTitle" name="recommendationTitle"
                    placeholder="Enter recommendation title" autofocus required>
            </div>

            <div class="form-group">
                <label for="recommendationType">Related to:</label>
                <select id="recommendationType" name="recommendationType">
                    <option value="Teaching Method">Teaching Method</option>
                    <option value="Assesment">Assesment</option>
                    <option value="Program Effectivness">Program Effectivness</option>
                </select>
            </div>

            <div class="form-group">
                <label for="recommendationDescription">Recommendation Description:</label>
                <textarea id="recommendationDescription" name="recommendationDescription" rows="8" cols="50"
                    placeholder="Enter recommendation description" required></textarea>
            </div>

            <button class="create-button update" type="submit" name="submit_recommendation">Create</button>
        </form>
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
                <li><a class="active" href="qaofficerportal.php">Home</a></li>
                <li><a href="qapolicies.php">Policies</a></li>
                <li><a href="qaevaluations.php">Recomendations</a></li>
                <li><a class="active" href="qaofficerportal.php">Profile</a></li>
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