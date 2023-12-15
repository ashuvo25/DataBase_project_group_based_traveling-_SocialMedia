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

        $fields .= "$field,";
        $values .= "'$value',";
    }

    $fields = rtrim($fields, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO group_details ($fields) VALUES ($values)";

    if ($conn->query($sql)) {
        $group_id = $conn->insert_id;


        $email = $_SESSION['email'];

        $sql_2 = "INSERT INTO group_signups (username, email, Group_ID) VALUES ('$_SESSION[username]', '$email', $group_id)";

        $insertSql = "INSERT INTO group_member(group_id, member, request) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);

        // Create a variable for the "NO" value
        $requestValue = "YES";

        $insertStmt->bind_param("iss", $group_id, $_SESSION['username'], $requestValue);


        if ($conn->query($sql_2)) {
            // echo "Insert successful";
            // header("Location: Home_pages/Pagess/Trip/trip.php ? groupid= $group_id");
        } else {
            echo "Error inserting into group_signups: " . $conn->error;
        }
        if ($insertStmt->execute()) {
            $groupid = NULL;
            header('Location: index.php');
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

    $query = "SELECT * FROM personal_messages WHERE (sender_username = ? AND receiver_username = ?) OR (sender_username = ? AND receiver_username = ?) ORDER BY timestamp ASC";
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
              ORDER BY gm.timestamp ASC";

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

    $query = "SELECT DISTINCT u.name AS friend_name, MAX(m.timestamp) AS timestamp, u.username,u.prof_text
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
        //echo "0 results";
        return null;
    }
}

function getGroupList($loggedInUser)
{
    global $conn;

    $query = "SELECT DISTINCT gd.Group_ID, Title AS group_name, gd.Start_date
          FROM group_member gm
          JOIN group_details gd ON gm.group_id = gd.Group_ID
          WHERE gm.member = ? AND gm.group_id IS NOT NULL AND gm.request = 'YES'
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
        // echo "0 results";
        return null;
    }
}









function group_view($domain)
{
    global $conn;

    $sql = "SELECT group_details.*, signups.name,signups.prof_text
            FROM group_details
            LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
            LEFT JOIN signups ON group_signups.username = signups.username AND group_signups.email = signups.email
            WHERE (group_details.Privacie = 'Public' OR signups.domain = '$domain') and group_details.Start_date>CURRENT_DATE
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
        // echo "0 results";
        return null;
    }
}


function search_group_view($domain, $search_params)
{
    global $conn;


    $startLocation = $search_params['start_location'] ?? null;
    $endLocation = $search_params['end_location'] ?? null;
    $startDate = $search_params['start_date'] ?? null;
    $university=$search_params['university']??null;

  
    $whereClause = "(group_details.Privacie = 'Public' OR signups.domain = '$domain') and group_details.Start_date > CURRENT_DATE";

    if (!empty($startLocation)) {
        $whereClause .= " AND group_details.FromLocation = '$startLocation'";
    }

    if (!empty($endLocation)) {
        $whereClause .= " AND group_details.ToLocation = '$endLocation'";
    }

    if (!empty($startDate)) {
        $whereClause .= " AND group_details.Start_date >= '$startDate'";
    }
    if(!empty($university)){
        $whereClause .=" AND signups.domain = '$domain'";
    }

    // Construct the final SQL query
    $sql = "SELECT group_details.*, signups.name, signups.prof_text
            FROM group_details
            LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
            LEFT JOIN signups ON group_signups.username = signups.username AND group_signups.email = signups.email
            WHERE $whereClause
            ORDER BY signups.verified DESC, group_details.Time DESC, group_details.Privacie";

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
        return null;
    }
}



function host_group_view($username)
{
    global $conn;

    $sql = "SELECT group_details.*, signups.name,signups.prof_text,group_signups.username
    FROM group_details
    LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
    LEFT JOIN signups ON group_signups.username = signups.username AND group_signups.email = signups.email
    WHERE  group_signups.username='$username' 
    ORDER BY group_signups.timestamp DESC ";

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
        // echo "0 results";
        return null;
    }
}




function updatePassword($username, $newPassword)
{
    global $conn;


    $sql = "UPDATE signups SET passwords=? WHERE username=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ss", $newPassword, $username); // Replace $newPassword with $hashedPassword if using hashing

        // Execute the statement
        if ($stmt->execute()) {
            echo '  <script>alart("Password updated successfully")</script>';
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
                "verified" => $row['verified'],
                "bio" => $row['bio'],
                "domain"=>$row['domain'],

            );
        }
        return $user;
    } else {
        // echo "0 results";
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


    $sql = "UPDATE signups SET ";

    foreach ($FormData as $field => $value) {

        if (in_array($field, $excludeFields) || $value === null || strlen($value) <= 0) {
            continue;
        }

        $field = mysqli_real_escape_string($conn, $field);
        $value = mysqli_real_escape_string($conn, $value);




        $sql .= "$field='$value',";
    }


    $sql = rtrim($sql, ',');


    $sql .= " WHERE username = '$_SESSION[username]'";



    $result = $conn->query($sql);

    if ($result) {
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

function group_details($groupid)
{
    global $conn;

    $sql = "SELECT group_details.*, signups.*
    FROM group_details
    LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
    LEFT JOIN signups ON group_signups.username = signups.username AND group_signups.email = signups.email
    WHERE group_details.Group_ID=$groupid";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of the first row
        $row = $result->fetch_assoc();

        // Use array_combine to merge column names with their respective values
        return array_combine(array_keys($row), $row);
    } else {
        // echo "0 results";
        return null;
    }
}


function add_request($groupid)
{
    global $conn;

    $sql = "SELECT signups.*, group_member.group_id
            FROM group_member, signups
            WHERE group_member.member = signups.username 
            AND group_member.group_id = $groupid 
            AND group_member.request = 'NO'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = array();

        // Loop through all rows in the result set
        while ($row = $result->fetch_assoc()) {
            // Add each row to the $rows array
            $rows[] = $row;
        }

        return $rows;
    } else {
        //echo "0 results";
        return null;
    }
}

function onlymember($username)
{
    global $conn;

    // Using a prepared statement to prevent SQL injection
    $sql = "SELECT group_details.*,group_signups.username
    FROM group_details
    LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
    LEFT JOIN group_member ON group_member.group_id = group_details.Group_ID
                           AND group_member.member = ?
    WHERE !(group_member.member = group_signups.username AND group_member.group_id = group_signups.Group_ID)
          AND group_member.request = 'YES'
    ORDER BY group_signups.timestamp DESC, group_details.Privacie ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Assuming $username is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $groups = array();
        while ($row = $result->fetch_assoc()) {
            $group = array();
            foreach ($row as $key => $value) {
                $group[$key] = $value;
            }
            $groups[] = $group;
        }
        return $groups;
    } else {
        return null;
    }
}


function getUsersWhoFollowMe($username)
{
    global $conn;

    $query = "SELECT  s.*
               FROM signups s
               LEFT JOIN connection c ON s.username = c.follower
               WHERE c.following = ? ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $users = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }

    return $users;
}

function deleteConnection($following, $follower)
{
    global $conn;

    $sql = "DELETE FROM `connection` WHERE `following` = ? AND `follower` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $following, $follower);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true; // Deletion was successful
    } else {
        return false; // Deletion did not occur or had no effect
    }
}


function insertConnection($following, $follower)
{
    global $conn;


    $sql = "INSERT INTO `connection` (`following`, `follower`) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $following, $follower);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}


function checkIfUsersFollowEachOther($user1, $user2)
{
    global $conn;

    // Check if $user1 follows $user2
    $query1 = "SELECT 1
               FROM connection
               WHERE follower = ? AND following = ?";

    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "ss", $user1, $user2);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);

    // Check if $user2 follows $user1
    $query2 = "SELECT 1
               FROM connection
               WHERE follower = ? AND following = ?";

    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "ss", $user2, $user1);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    // Return true if both users follow each other, otherwise return false
    return mysqli_num_rows($result1) > 0 && mysqli_num_rows($result2) > 0;
}
function countFollowing($type, $user)
{
    global $conn;

    if ($type == "follower") {
        $query = "SELECT COUNT(*) AS followingCount
        FROM connection
        WHERE `following` = ?";
    } elseif ($type == "following") {
        $query = "SELECT COUNT(*) AS followingCount
        FROM connection
        WHERE `follower` = ?";
    } elseif ($type == "host") {
        $query = "SELECT COUNT(*) AS followingCount
        FROM group_signups
        WHERE `username` = ?";
    } elseif ($type == "total") {
        $query = "SELECT COUNT(*) AS followingCount
        FROM group_member
        WHERE `member` = ? and request='YES' ";
    }



    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);


    mysqli_stmt_close($stmt);


    return $row['followingCount'];
}
function group_member($group_id)
{
    global $conn;
    $sql = "SELECT group_member.*, signups.*
            FROM group_member, signups
            WHERE group_member.member = signups.username AND group_member.request = 'YES' AND group_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $group_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $output = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $output[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $output;
}

