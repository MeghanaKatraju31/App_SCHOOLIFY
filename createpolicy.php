<?php

include_once('functions.php');
if (isset($_POST['submit_policy'])) {
    if (submitPolicy()) {
        echo '<script>alert("Policy Added Succesfully!")</script>';
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
    <link rel="stylesheet" type="text/css" href="css/createpolicy.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Create Policy</title>
    <script>
        function validateForm() {
            const policyTitle = document.getElementById("policyTitle").value;
            const policyType = document.getElementById("policyType").value;
            const policyDescription = document.getElementById("policyDescription").value;

            if (policyTitle.trim() === "" || policyType === "" || policyDescription.trim() === "") {
                alert("Please fill in all the required fields.");
                return false
            }
            return true
        }
    </script>
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
            <ul class="iconsnav"><li>
                <a href="#">
                    <i class="fas fa-bell"></i>
                    <div class="notification-popup">
                        <p>No notifications yet</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" ><i class="fas fa-user"></i></a>
                <ul class="dropdown">
                    <li><a href="qaofficerprofile.php">Profile</a></li>
                    <li><a href="home.php">Logout</a></li>
                </ul>
            </li></ul>
            <ul class="navmenu">
                <li><a  href="qaofficerportal.php">Home</a></li>
                <li><a href="qapolicies.php" class="active">POLICIES</a></li>
                <li><a href="qarecomendations.php">RECOMENDATIONS</a></li>
                <li><a href="studentperformance.php">STUDENT PERFORMANCE</a></li>
                <li class="hidethem"><a href="qaofficerprofile.php">Profile</a></li>
                <li class="hidethem"><a href="home.php">Logout</a></li>
                
            </ul>
        </nav>
        <section></section>
    </header>
    <div class="create-policy-form">
        <h2>Create New Policy</h2>
        <form method="POST" onsubmit="return validateForm()">
            <input hidden type="text" name="qa_id" value="<?php echo $qa['qa_id']?>">
            <div class="form-group">
                <label for="policyTitle">Policy Title:</label>
                <input type="text" id="policyTitle" name="policyTitle" placeholder="Enter policy title" autofocus
                    required>
            </div>

            <div class="form-group">
                <label for="policyType">Policy Type:</label>
                <select id="policyType" name="policyType">
                    <option value="generic">Generic</option>
                    <option value="instructor">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="programCoordinator">Program Coordinator</option>

                </select>
            </div>

            <div class="form-group">
                <label for="policyDescription">Policy Description:</label>
                <textarea id="policyDescription" name="policyDescription" rows="8" cols="50"
                    placeholder="Enter policy description" required></textarea>
            </div>

            <button class="create-button update" type="submit" name="submit_policy">Create</button>
        </form>
    </div>


</body>
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
</html>
