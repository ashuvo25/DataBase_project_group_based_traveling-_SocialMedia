<!DOCTYPE html>
<?php
// Assume you have a database connection

include(__DIR__ . '/../DBconnection.php');
$sender = $_SESSION['username'];

if (isset($_GET['receiver'])) {
    $_SESSION['reciver'] = $_GET['receiver'];

    // Update other relevant variables as needed
}
$receiver = $_SESSION['reciver'];

// $receiver = $_SESSION['receiver'];

$friendinfo = select_profile_edit($receiver);



$ChatList = getChatList($sender);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['messageInput'])) {
        $messageText = $_POST['messageInput'];
        SendMessage($messageText, $receiver, $sender);
    }
    header('location: index.php');
}

// Set Content Type Header to HTML


// print_r($_POST); // Debugging line
// $conn->close();
?>



<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body >
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <div class="container" style="margin-top: 0px; " >
        <div class="row clearfix" >
            <div class="col-lg-12" >
                <form method="post">

                    <div class="card chat-app">
                        <a href="/Home_pages/home.php" style="color:#fff;" > <img src="/Home_pages/image/icons/next.png" class="chat_back"> &nbsp BACK</a>
                        <div id="plist" class="people-list">

                            <!-- <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search...">
                            </div> -->

                            <ul class="list-unstyled chat-list mt-2 mb-0">
                                <li class="clearfix" style="background-color: aqua;">
                                    <a href="group_index.php">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                        <div class="about">
                                            <div class="name" >Group Chat</div>
                                            <!-- <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div> -->
                                        </div>
                                    </a>
                                </li>

                                <?php if ($ChatList == null || empty($ChatList)) : ?>
                                    <li class="clearfix">


                                        <div class="about">
                                            <div class="name">No User found</div>

                                        </div>

                                    </li>
                                <?php else : ?>
                                    <?php foreach ($ChatList as $user) :
                                        $link = select_profile_edit($user['username']); ?>


                                        <li class="clearfix">
                                            <a href="index.php?receiver=<?= $user['username'] ?>" style="color: #fff;" >
                                                <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>">

                                                <div class="about">
                                                    <div class="name"><?= $user['friend_name'] ?></div>
                                                    <div class="status">
                                                        <i class="fa fa-circle <? //= $user['statusClass'] 
                                                                                ?>"></i>
                                                        <?= $user['timestamp'] ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>




                            </ul>
                            </ul>
                        </div>
                        <div class="chat">

                            <div class="chat-header clearfix">

                                <div class="row">

                                    <div class="col-lg-6">
                                        <?php if ($friendinfo == null) : ?>
                                            <div class="chat-about">
                                                <h6 class="m-b-0">Select User</h6>

                                            </div>
                                        <?php else : ?>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                                <img src="<?php echo '/Home_pages/uploads/' . $friendinfo['image']; ?>">
                                            </a>
                                            <div class="chat-about">
                                                <h6 class="m-b-0"><?php echo $friendinfo['name'] ?></h6>
                                                <!-- <small>Last seen: <?php echo $friendInfo['last_seen'] ?></small> -->
                                            </div>
                                        <?php endif; ?>
                                    </div>



                                    <div class="col-lg-6 hidden-sm text-right">
                                        <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                        <a href="/Home_index.php" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                        <a href="E:\University\Programming\Web Design\Profile\Home_index.php ?username=<?= $friendinfo['username'] ?>" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                                        <!-- E:\University\Programming\Web Design\Profile\Home_index.php -->
                                    </div>
                                </div>

                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

                            <div class="chat-history" id="chatHistoryContainer">
                                <?php $messages = getPersonalMessages($sender, $receiver); ?>
                                <ul id="chatHistory" class="m-b-0">
                                    <?php foreach ($messages as $message) :
                                        $link = select_profile_edit($message['sender_username']); ?>
                                        <li class="clearfix">
                                            <div class="message-data <?php echo ($message['sender_username'] == $sender) ? 'text-right' : ''; ?>">
                                                <span class="message-data-time"><?php echo date('H:i', strtotime($message['timestamp'])), "...", $message['sender_username']; ?></span>
                                                <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>">
                                            </div>
                                            <div class="message <?php echo ($message['sender_username'] == $sender) ? 'other-message float-right' : 'my-message'; ?>">
                                                <?php echo $message['message_text']; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                    <div id="scrollAnchor" style = " background:#003554;color:#003554; "></div>
                                </ul>
                            </div>

                            <!-- // After adding messages, set the scroll position to the anchor -->
                            <script>
                                window.location = "#scrollAnchor";
                            </script>

                            <script>
                                $(document).ready(function() {
                                    // var counter = 9;
                                    window.setInterval(function() {
                                        // counter = counter - 3;
                                        // if (counter >= 0) {
                                        //     document.getElementById('off').innerHTML = counter;
                                        // }
                                        // if (counter === 0) {
                                        //     counter = 9;
                                        // }
                                        $("#chatHistoryContainer").load(window.location.href + " #chatHistoryContainer");
                                    }, 3000);

                                });
                            </script>
                            <div class="chat-message clearfix" >
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-send"></i></span>
                                    </div>
                                    <input type="text" id="messageInput" name="messageInput" class="form-control" placeholder="Enter text here...">
                                    <!-- <button type="button" name="button" class="btn btn-primary" onclick="sendMessage()">Send</button> -->
                                    <button type="submit" name="button" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script type="text/javascript">
        function sendMessage() {
            var messageText = $('#messageInput').val();
            var receiver = 'Shuvo'; // You may need to dynamically get the receiver's username

            // Prevent the default form submission
            event.preventDefault();

            // Serialize form data
            var formData = $('#messageForm').serializeArray();
            formData.push({
                name: 'receiver',
                value: receiver
            });

            // Send data to the server
            $.post('E:/University/Programming/Web Design/DBconnection.php', formData, function(data) {
                console.log(data);
                // Optionally, update the chat history after sending a message
                getMessages(receiver);
            });
        }

        // ... your existing code ...
    </script> -->


</body>

</html>