<?php
include_once('functions.php');

$chats = get_all_chats();
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

include_once('adminheader.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/adminheader.css">
    <link rel="stylesheet" type="text/css" href="css/imagewithtext.css">
    <link rel="stylesheet" type="text/css" href="css/chatbtn.css">
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jacques+Francois&display=swap" rel="stylesheet">
    <title>Program Coordinator Chat</title>
</head>

<body>
  
    <div class="image-with-text">
        <div class="overlay"></div>
        <img src="./images/bg1.jpeg" alt="University Image">
        <div class="image-text-container">
            <h2 class="image-text">CHATS</h2>
        </div>
    </div>
    <a href="adminstartchat.php" class="create-chat-button">Start New Chat</a>

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


</body>

</html>
<?php 
include_once('adminfooter.php'); ?>