<!DOCTYPE html>
<?php
// Assume you have a database connection

include(__DIR__ .'/../DBconnection.php');
$sender =  $_SESSION['username'];
// set the settion group in home page
if (isset($_GET['receiver'])) {
    $_SESSION['groupID'] = $_GET['receiver'];

    // Update other relevant variables as needed
}
$groupID = $_SESSION['groupID'];

$groupInfoQuery = "SELECT Title as group_name, Start_date FROM group_details WHERE Group_ID = ?";
$stmt = $conn->prepare($groupInfoQuery);

if (!$stmt) {
    // Handle the error or display a default value
    $groupInfo = [
        'group_name' => 'Group Name Not Available',
        'Start_date' => 'Start Date Not Available'
    ];
} else {
    $stmt->bind_param("i", $groupID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $groupInfo = $result->fetch_assoc();
    } else {
        // Handle the error or display a default value
        $groupInfo = [
            'group_name' => 'Group Name Not Available',
            'Start_date' => 'Start Date Not Available'
        ];
    }

    $stmt->close();
}

$messages = getGroupMessages($groupID);


$groupChatList = getGroupList($sender);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['messageInput'])) {
        $messageText = $_POST['messageInput'];
        sendGroupMessage($messageText, $groupID, $sender);
    }
    header('location: group_index.php');
    exit();
}

// Set Content Type Header to HTML


// print_r($_POST); // Debugging line
$conn->close();
?>



<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chat App - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <form method="post">

                    <div class="card chat-app">
                        <div id="plist" class="people-list">
                            <!-- <div class="input-group">
                               <li class="clearfix" style="background-color: cyan;">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                    <div class="about">
                                        <div class="name">Group Chat</div>
                                        <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div>
                                    </div>
                                </li>
                            </div> -->
                            <ul class="list-unstyled chat-list mt-2 mb-0">
                                <li class="clearfix" style="background-color: lime;">
                                    <a href="index.php">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                        <div class="about">
                                            <div class="name">Personal Chat</div>
                                            <!-- <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div> -->
                                        </div>
                                    </a>
                                </li>
                                <?php if ($groupChatList == null || empty($groupChatList)) : ?>
                                    <li class="clearfix">


                                        <div class="about">
                                            <div class="name">No User found</div>

                                        </div>

                                    </li>
                                <?php else : ?>
                                    <?php foreach ($groupChatList as $user) : ?>
                                        <li class="clearfix">
                                            <a href="group_index.php? receiver=<?= $user['group_id'] ?>">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                                <div class="about">
                                                    <div class="name"><?= $user['group_name'] ?></div>
                                                    <div class="status">
                                                        <i class="fa fa-circle <? //= $user['statusClass'] 
                                                                                ?>"></i>
                                                        <?= $user['start_date'] ?>
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
                                    <?php if ($groupInfo == null) : ?>
                                        <div class="chat-about">
                                            <h6 class="m-b-0">Select Group</h6>

                                        </div>
                                    <?php else : ?>

                                        <div class="col-lg-6">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                            </a>
                                            <div class="chat-about">
                                                <h6 class="m-b-0"><?php echo $groupInfo['group_name'] ?></h6>
                                                <!-- <small>Last seen: <?php //echo $groupInfo['] 
                                                                        ?></small> -->
                                            </div>

                                        </div>
                                    <?php endif; ?>



                                    <!-- <div class="col-lg-6 hidden-sm text-right">
                                        <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                        <a href="/Home_index.php" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                        <a href="http://localhost:3000/Profile_Edit/Home_index.php?username=<?= $friendinfo['username'] ?>" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                                     -->

                                <!-- </div> -->

                            </div>

                        </div>

                        <div class="chat-history">
                            <ul id="chatHistory" class="m-b-0">
                                <?php foreach ($messages as $message) : ?>
                                    <li class="clearfix">
                                        <div class="message-data <?php echo ($message['sender_username'] == $sender) ? 'text-right' : ''; ?>">
                                            <?php echo date('H:i', strtotime($message['timestamp'])), "...", $message['sender_username']; ?></span>
                                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                        </div>
                                        <div class="message <?php echo ($message['sender_username'] == $sender) ? 'other-message float-right' : 'my-message'; ?>">
                                            <?php echo $message['message_text']; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
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

</body>

</html>