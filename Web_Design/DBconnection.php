<?php

$hostName = 'localhost:3307';
$dbUser = 'root';
$dbpassword = "";
$dbName = "dbms_project";
$conn = mysqli_connect($hostName, $dbUser, $dbpassword, $dbName);
if (!$conn) {
    die("Somthing went wrong");
}

session_start();

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function insertGroup($FormData)
{
    global $conn;

    if (empty($FormData)) {
        echo "No data provided for insert";
        return;
    }

    $fields = '';
    $values = '';

    foreach ($FormData as $field => $value) {
        if ($value === null || strlen($value) <= 0) {
            continue;
        }

        $field = mysqli_real_escape_string($conn, $field);
        $value = mysqli_real_escape_string($conn, $value);

        $fields .= "`$field`,";
        $values .= "'$value',";
    }

    $fields = rtrim($fields, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO `group_details` ($fields) VALUES ($values)";

    if ($conn->query($sql)) {
        $group_id = $conn->insert_id;


        $email = $_SESSION['email'];

        $sql_2 = "INSERT INTO group_signups (username, email, Group_ID) VALUES ('$_SESSION[username]', '$email', $group_id)";
        if ($conn->query($sql_2)) {
            // echo "Insert successful";
        } else {
            echo "Error inserting into group_signups: " . $conn->error;
        }
    } else {
        echo "Error inserting into group: " . $conn->error;
    }
}



function SendMessage($messageText, $receiver, $sender)
{
    global $conn;

    if (empty($messageText)) {
        echo "No data provided for insert";
        return;
    }

    $stmt = $conn->prepare("INSERT INTO personal_messages (sender_username, receiver_username, message_text) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sss", $sender, $receiver, $messageText);

    // Execute the statement
    $stmt->execute();
}

function sendGroupMessage($messageText, $groupID, $sender)
{
    global $conn;

    if (empty($messageText)) {
        echo "No data provided for insert";
        return;
    }

    $stmt = $conn->prepare("INSERT INTO group_messages (group_id, sender_username, message_text) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("iss", $groupID, $sender, $messageText);

    // Execute the statement
    $stmt->execute();
}


function getPersonalMessages($sender, $receiver)
{
    global $conn;

    $query = "SELECT * FROM personal_messages WHERE (sender_username = ? AND receiver_username = ?) OR (sender_username = ? AND receiver_username = ?) ORDER BY timestamp desc";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $sender, $receiver, $receiver, $sender);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}

function getGroupMessages($groupID)
{
    global $conn;

    $query = "SELECT gm.*, u.name AS sender_name
              FROM group_messages gm
              JOIN signups u ON gm.sender_username = u.username
              WHERE gm.group_id = ?
              ORDER BY gm.timestamp DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $groupID);
    $stmt->execute();

    $result = $stmt->get_result();

    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $message = [
            "message_id" => $row["Message_ID"],
            "group_id" => $row["Group_ID"],
            "sender_username" => $row["Sender_Username"],
            "sender_name" => $row["sender_name"],
            "message_text" => $row["Message_Text"],
            "timestamp" => $row["Timestamp"]
        ];

        $messages[] = $message;
    }

    return $messages;
}


function getChatList($loggedInUser)
{
    global $conn;

    $query = "SELECT DISTINCT u.name AS friend_name, MAX(m.timestamp) AS timestamp, u.username
    FROM signups u
    JOIN personal_messages m ON u.username = m.sender_username OR u.username = m.receiver_username
    WHERE (m.sender_username = ? OR m.receiver_username = ?) AND u.username != ?
    GROUP BY friend_name, u.username
    ORDER BY timestamp DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $loggedInUser, $loggedInUser, $loggedInUser);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
        return null;
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $friends = array();
        $friendNames = array(); // to track unique names

        while ($row = $result->fetch_assoc()) {
            $friendName = $row["friend_name"];

            // Check if the friend name is not in the list of unique names
            if (!in_array($friendName, $friendNames)) {
                $friend = [
                    "friend_name" => $friendName,
                    "timestamp" => $row["timestamp"],
                    "username" => $row["username"]
                ];

                $friends[] = $friend;
                $friendNames[] = $friendName; // add to the list of unique names
            }
        }

        return $friends;
    } else {
        echo "0 results";
        return null;
    }
}

function getGroupList($loggedInUser)
{
    global $conn;

    $query = "SELECT DISTINCT gd.Group_ID, CONCAT(gd.FromLocation, '_', gd.ToLocation) AS group_name, gd.Start_date
              FROM group_member gm
              JOIN group_details gd ON gm.group_id = gd.Group_ID
              WHERE gm.member = ? AND gm.group_id IS NOT NULL
              GROUP BY gd.Group_ID
              ORDER BY gd.Start_date DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $loggedInUser);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
        return null;
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $groups = array();

        while ($row = $result->fetch_assoc()) {
            $group = [
                "group_id" => $row["Group_ID"],  // Adjusted to use the correct column name
                "group_name" => $row["group_name"],
                "start_date" => $row["Start_date"]  // Adjusted to use the correct column name
            ];

            $groups[] = $group;
        }

        return $groups;
    } else {
        echo "0 results";
        return null;
    }
}









function group_view()
{
    global $conn;

    $sql = "SELECT group_details.*, signups.name
            FROM group_details
            LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
            LEFT JOIN signups ON group_signups.username = signups.username AND group_signups.email = signups.email
            WHERE group_details.Privacie = 'Public' OR signups.verified = 'YES'
            ORDER BY signups.verified DESC, group_details.Time DESC, group_details.Privacie ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $groups = array(); // Initialize an array to store multiple rows
        while ($row = $result->fetch_assoc()) {
            $group = array();
            foreach ($row as $key => $value) {
                $group[$key] = $value; // Map the attribute name to its value
            }
            $group["User_Name"] = $row["name"]; // Add the "User_Name" attribute
            $groups[] = $group; // Append the current row to the array
        }
        return $groups;
    } else {
        echo "0 results";
        return null;
    }
}





function updatePassword($username, $newPassword)
{
    global $conn;


    $sql = "UPDATE `signups` SET `passwords`=? WHERE `username`=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ss", $newPassword, $username); // Replace $newPassword with $hashedPassword if using hashing

        // Execute the statement
        if ($stmt->execute()) {
            echo "Password updated successfully";
        } else {
            echo "Error updating password: " . $stmt->error;
        }
    }
}








function select_profile_edit($username)
{
    global $conn;

    $sql = "SELECT * FROM signups WHERE username = '$username'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        $user = array();
        while ($row = $result->fetch_assoc()) {
            $user = array(
                "passwords" => $row["passwords"],
                "username" => $row["username"],
                "name" => $row["name"],
                "email" => $row["email"],
                "age" => $row["age"],
                "image" => $row["prof_text"],
                // "number" => $row["number"],
                // "website" => $row["website"],
                // "company" => $row["company"]

            );
        }
        return $user;
    } else {
        echo "0 results";
        return null;
    }
}







function updateProfile($FormData)
{
    global $conn;

    if (empty($FormData)) {
        echo "No data provided for update";
        return;
    }




    $excludeFields = ['currentPassword', 'newPassword', 'repeatNewPassword'];


    $sql = "UPDATE `signups` SET ";

    foreach ($FormData as $field => $value) {

        if (in_array($field, $excludeFields) || $value === null || strlen($value) <= 0) {
            continue;
        }

        $field = mysqli_real_escape_string($conn, $field);
        $value = mysqli_real_escape_string($conn, $value);




        $sql .= "`$field`='$value',";
    }


    $sql = rtrim($sql, ',');


    $sql .= " WHERE `username`='$_SESSION[name]'";


    $result = $conn->query($sql);

    if ($result) {
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
