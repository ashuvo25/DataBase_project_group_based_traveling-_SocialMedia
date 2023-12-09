<?php

$hostName ='localhost:3307';
$dbUser = 'root';
$dbpassword="";
$dbName = "dbms_project";
$conn = mysqli_connect($hostName ,$dbUser ,$dbpassword,$dbName);
 if(!$conn){
    die("Somthing went wrong");
 }



// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// function insertGroup($title, $from, $to, $start_date, $end_date, $gender, $type_of_journey, $itinerary, $mobile_number,$privacies)
// {
//     global $conn;
//     $sql = "INSERT INTO `group` ( Title, `From`, `to`, `Start_date`, End_date, Gender, Type_of_journey, Itinerary, Mobile_number,Privacie)
//             VALUES ('$title', '$from', '$to', '$start_date', '$end_date', '$gender', '$type_of_journey', '$itinerary', '$mobile_number','$privacies')";

//     if ($conn->query($sql) === TRUE) {
//         //echo "Successfully inserted data";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }





function group_view()
{
    global $conn;

    $sql = "SELECT group_details.*, signups.name
            FROM group_details
            LEFT JOIN group_signups ON group_details.Group_ID = group_signups.Group_ID
            LEFT JOIN signups ON group_signups.username = signups.username AND group_signups.email = signups.email
            WHERE group_details.Privacie IN ('Public', 'Private')";

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





function updatePassword($username, $newPassword){
    global $conn;

    // Hash the new password (use a secure hashing algorithm)
    // Example: $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
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








function select_profile_edit($username){
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
                "verified_mail" => $row["verified_mail"],
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







function updateProfile($user, $profileData) {
    global $conn;

    if (empty($profileData)) {
        echo "No data provided for update";
        return;
    }

   
    $excludeFields = ['currentPassword', 'newPassword', 'repeatNewPassword'];

  
    $sql = "UPDATE `signups` SET ";

    foreach ($profileData as $field => $value) {
       
        if (in_array($field, $excludeFields) || $value === null || strlen($value)<=0) {
            continue;
        }

        $field = mysqli_real_escape_string($conn, $field);
        $value = mysqli_real_escape_string($conn, $value);
        $sql .= "`$field`='$value',";
    }

   
    $sql = rtrim($sql, ',');

    
    $sql .= " WHERE `username`='$user'";


    $result = $conn->query($sql);

    if ($result) {
   
    } else {
        echo "Error updating profile: " . $conn->error;
    }
    return;
}







//$conn->close(); // Close the connection after using it
?>
