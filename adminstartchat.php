<?php
include_once('getChatWithListAjax.php');
if(isset($_POST['chat_submit'])) {


    if (chat_submit()) {
        echo '<script>alert("Message send!")</script>';
        header("Location: adminchat.php");
        exit();

    } else {
        echo '<script>alert("Failed!")</script>';
    }
//    $chats=get_chats();

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/adminheader.css">
    <link rel="stylesheet" type="text/css" href="css/imagewithtext.css">
    <link rel="stylesheet" type="text/css" href="css/chatbtn.css">
    <link rel="stylesheet" type="text/css" href="css/startchat.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Student chat</title>
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

    <!--CHATS-->
    <div class="create-chat-form">
        <h2>Start New Chat</h2>
        <form  method="post">
            <div class="form-group">
                <label for="chatWith">Chat with:</label>
                <select id="chatWith" name="chatWith" required>
                    <option >Select role</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                    <option value="instructor">Instructor</option>
                    <option value="qa_officer">QA Officer </option>
                    <option value="program_coordinator">Program Coordinator </option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="selectinstructor">Select Instructor:</label>
                <select id="selectinstructor" name="selectinstructor" required>
                    <!-- Options will be populated dynamically using JavaScript -->
                </select>
            </div>
            <input type="text" name="role" id="role" hidden  value="">

            <div class="form-group">
                <label for="message">Leave a message:</label>
                <textarea id="message" name="message" rows="8" cols="50" placeholder="Enter your message" required></textarea>
            </div>

            <button class="create-button update" type="submit" name="chat_submit">Create</button>
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
                <li><a href="adminportal.php">Home</a></li>
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
<script>
    $(document).ready(function () {
        // Populate the instructor dropdown based on the selected chatWith option
        $('#chatWith').change(function () {
            var selectedOption = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'getChatWithListAjax.php', // Change this to the server file that fetches instructors based on the selected chatWith
                data: { chatWith: selectedOption },

                success: function (data) {

                    document.getElementById('role').value=selectedOption;
                    $('#selectinstructor').html(data);

                }
            });
        });


    });
</script>
</html>