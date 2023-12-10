<?php
include(__DIR__.'/../../Web_Design/DBconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $query = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $senderId, $receiverId);

    $senderId = 2;
    $receiverId = $userId;

    if ($stmt->execute()) {
        echo "Friend request sent successfully!";
    } else {
        echo "Error sending friend request!";
    }

    $stmt->close();
}

$conn->close();
?>
