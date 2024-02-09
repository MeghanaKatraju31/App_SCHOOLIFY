<?php
include_once('functions.php');
$chat_with_id = $_GET['chat_with_id'];
$chat_from_id = $_GET['chat_from_id'];
$chat_with_role = $_GET['chat_with_role'];
$chat_from_role = $_GET['chat_from_role'];
$par_chat = get_particular_chat($chat_with_id,$chat_with_role,$chat_from_id,$chat_from_role);
$chats = get_all_chats();
if(isset($_POST['chat_submit'])) {
    $chats = get_all_chats();

//    print_r($_POST);
//    exit;
    if (chat_submit()) {
        echo '<script>alert("Message send!")</script>';
        header("Location: adminchatonclick.php?chat_with_id=".$chat_with_id."&chat_with_role=".$chat_with_role."&chat_from_id=".$chat_from_id."&chat_from_role=".$chat_from_role);
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
    <link rel="stylesheet" type="text/css" href="css/continuechat.css">
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Student Chat</title>
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
    <div class="image-with-text">
        <div class="overlay"></div>
        <img src="./images/bg1.jpeg" alt="University Image">
        <div class="image-text-container">
            <h2 class="image-text">CHATS</h2>
        </div>
    </div>
    <a href="programcoordinatorstartchat.php" class="create-chat-button">Start New Chat</a>

    <!--CHATS-->
    <!--CHATS-->
    <div class="chat">
        <h6>Recent Chats</h6>
        <div class="responsivetable">
            <table class="chat-table">
                <thead>
                <tr>
                    <th>Chat with</th>
                    <th>Role</th>
                    <th>Last time chat</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($chats as $chat) {

                    $chat_with_name = get_chat_with_name($chat['chat_with'],$chat['role']);
                    ?>
                    <tr>
                        <td><?=$chat_with_name?></td>
                        <td><?=getRoleFullText($chat['role'])?></td>
                        <td><?=date('M d,Y H:i a',strtotime($chat['chat_date']))?></td>
                        <td>
                            <a href="adminchatonclick.php?chat_with_id=<?=$chat['chat_with']?>&chat_with_role=<?=$chat['role']?>&chat_from_id=<?=$chat['chat_from_id']?>&chat_from_role=<?=$chat['chat_from_role']?>" class="action-button view">Continue Chat</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>

        </div>
    </div>
    <div class="chat-container">
        <a href="adminchat.php">  <i class="fas fa-times close-icon"></i></a>

        <div class="messages">
            <?php
            foreach ($par_chat as $chat) {



                ?>
                <div class="<?=$chat['flag']?>" style="width: 100px">
                    <p><?=$chat['chat_message']?></p>
                    <span style="font-size: 12px;float: right"><?=date('H:i a',strtotime($chat['chat_date']))?></span>
                </div>
                <?php
            }
            ?>


        </div>
        <form  method="post">
            <div class="message-input">

                <input type="text" name="role" id="role" hidden  value="<?=$chat_with_role?>">

                <input type="text" name="selectinstructor" id="selectinstructor" hidden  value="<?=$chat_with_id?>">
                <input type="text" id="message" name="message" autofocus placeholder="Type your message">
                <button class="create-button update" type="submit" name="chat_submit">Send</button>
            </div>
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

</html>