<?php
include(__DIR__.'/../../Web_Design/DBconnection.php');
include('index.php');

// Fetch list of users
$query = "SELECT * FROM signups";
$result = $conn->query($query);

$users = array();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content remains the same as in index.html -->
</head>
<body>
    <div id="userList">
        <?php foreach ($users as $user) : ?>
            <div class="user" data-userid="<?= $user['user_id'] ?>">
                <?= $user['username'] ?>
                <button class="addFriendBtn">Add Friend</button>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
