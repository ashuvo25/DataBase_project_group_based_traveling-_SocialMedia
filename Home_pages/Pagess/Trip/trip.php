<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> </title>
    <link rel="stylesheet" href="trip.css">
</head>
<?php
include(__DIR__ . '/../../../Web_Design/DBconnection.php');

$group_id =   $_SESSION['view_group'];

if (isset($_GET["groupid"])) {
    $group_id = $_GET["groupid"];
    $_SESSION['view_group'] = $group_id;
}

$view_group = group_details($group_id);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $member = isset($_POST["member"]) ? htmlspecialchars($_POST["member"]) : "";
    $action = isset($_POST["action"]) ? htmlspecialchars($_POST["action"]) : "";
    $groupID = $group_id;

    // Update or delete the record in the group_member table
    if ($action === "accept") {
        // Use prepared statement to prevent SQL injection
        $query = $conn->prepare("UPDATE group_member SET request='YES' WHERE member=? AND group_id=?");
        $query->bind_param("si", $member, $groupID);
        $query->execute();
    } elseif ($action === "reject") {
        $query = "DELETE FROM group_member WHERE member=? AND group_id=?";
        $query = $conn->prepare($query);
        $query->bind_param("si", $member, $groupID);
        $query->execute();
    }

    // Redirect back to the previous page after handling the request
    header("Location: trip.php");
    exit();
}
?>

<!-- The rest of your HTML code remains unchanged -->


<body>
    <div class="trip_main">
        <header>
            <p style="color: coral ;"> <a href="/Web_Design/Profile_Edit/Home_index.php" style=" text-decoration: none ; color: coral;"> <img src="/Home_pages/image/icons/next.png" alt="" width="25px" class="back_logo">BACK TO TRIPS</a>
            </p>


        </header>
        <div class="img_links">
            <div class="image_section">
                <div class="image_name">
                    <img src="/Home_pages/uploads/0123.jpg" alt="" height="230px">
                    <p class="name"><?php echo $view_group["name"] ?></p>
                </div>

                <div class="text_side">
                    <h3><?php echo $view_group["Title"] ?> </h3>
                    <p class="date"><?php echo $view_group["Start_date"] . " to " . $view_group["End_date"] ?></p>
                    <p class="country"><img src="/Home_pages/image/icons/flag.png" alt="" width="25px"> country</p>
                    <p class="about"><?php echo $view_group["About_Tour"] ?></p>
                </div>

            </div>

            <div class="links_section">
                <!-- <button class="icon_btn baa" ><img src="/Home_pages/image/icons/message.png" alt="" width="25px">Send Message</button>
                <button class="icon_btn baa1"><img src="/Home_pages/image/icons/click.png" alt="" width="25px">Join this trip</button>
                <button class="icon_btn baa2"><img src="/Home_pages/image/icons/comments.png" alt="" width="25px">Comment</button>
                <button class="icon_btn baa3"><img src="/Home_pages/image/icons/wave.png" alt="" width="25px">Send a wave</button>
                <button class="icon_btn baa"><img src="/Home_pages/image/icons/favourite.png" alt="" width="25px">Add to Favorites</button> -->
                <a href="/Web_Design/Chat_Box/group_index.php?groupid=<?php echo $group_id; ?>"><button class="icon_btn baa" id="messageButton"><img src="/Home_pages/image/icons/message.png" alt="" width="25px">Send Message</button></a>
                <button class="icon_btn baa2"><img src="/Home_pages/image/icons/comments.png" alt="" width="25px">Comment</button>
                <button class="icon_btn baa1"><img src="/Home_pages/image/icons/click.png" alt="" width="25px">Edit Group</button>
                <button class="icon_btn baa3" id="requestButton"><img src="/Home_pages/image/icons/wave.png" alt="" width="25px">Request</button>


            </div>
            <div class="accpted">
            <header  style="  margin-left: 50px; ">
                <p style=" text-decoration: underline;  ">Team Members</p>
                </header>
                <?php
                $details_member = group_member($view_group["Group_ID"]);

                if ($details_member !== null) {
                    echo '<div class="notification">';
                    echo '<ul class="friend-request-list">';

                    foreach ($details_member as $detail_m) {
                        echo '<li class="friend-request">';
                        echo '<div class="friend-request-header">';
                        echo '<div class="friend-request-profile">';
                        echo '<img src=" /Home_pages/uploads/' . $detail_m['prof_text'] . '" alt="Profile Photo">';
                        echo '</div>';
                        echo '<div class="friend-request-info">';
                        echo '<p>' . $detail_m['name'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        // echo '<div class="friend-request-buttons">';
                        // echo '<form method="post" action="trip.php">';
                        // echo '<input type="hidden" name="member" value="' . $detail['username'] . '">';
                        // // echo '<input type="hidden" name="action" value="accept">';
                        // // echo '<button class="accept-button">Accept</button>';
                        // echo '</form>';

                        // echo '<form method="post" action="trip.php">';
                        // echo '<input type="hidden" name="member" value="' . $detail['username'] . '">';
                        // echo '<input type="hidden" name="action" value="reject">';
                        // echo '<button class="reject-button">Reject</button>';
                        // echo '</form>';
                        // echo '</div>';
                        echo '</li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="accpted_1">
            <header  style="  margin-left: 50px; ">
                <p style=" text-decoration: underline;  ">Requests</p>
                </header>

                <?php
                $details = add_request($view_group["Group_ID"]);

                if ($details !== null) {
                    echo '<div class="notification">';
                    echo '<ul class="friend-request-list">';

                    foreach ($details as $detail) {
                        echo '<li class="friend-request">';
                        echo '<div class="friend-request-header">';
                        echo '<div class="friend-request-profile">';
                        echo '<img src=" /Home_pages/uploads/' . $detail['prof_text'] . '" alt="Profile Photo">';
                        echo '</div>';
                        echo '<div class="friend-request-info">';
                        echo '<p>' . $detail['name'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="friend-request-buttons">';
                        echo '<form method="post" action="trip.php">';
                        echo '<input type="hidden" name="member" value="' . $detail['username'] . '">';
                        echo '<input type="hidden" name="action" value="accept">';
                        echo '<button class="accept-button">Accept</button>';
                        echo '</form>';

                        echo '<form method="post" action="trip.php">';
                        echo '<input type="hidden" name="member" value="' . $detail['username'] . '">';
                        echo '<input type="hidden" name="action" value="reject">';
                        echo '<button class="reject-button">Reject</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                } else {
                    echo 'No requests.';
                }
                ?>
            </div>
        </div>

        <div class="extras_item">
            <p> <img src="/Home_pages/image/icons/split.png" alt="" width="25px"> split costs : yes</p>
            <p> <img src="/Home_pages/image/icons/money-bag.png" alt="" width="25px"> Budget : <?php echo $view_group["Fare_1"] + $view_group["Fare_2"] + $view_group["Day"] * $view_group["Rent"] + $view_group["Other_Cost"] ?></p>
            <p> <img src="/Home_pages/image/icons/journey_type.png" alt="" width="25px"> Type Of Journey :<?php echo $view_group["Type_of_journey"] ?></p>
            <p> <img src="/Home_pages/image/icons/sex.png" alt="" width="25px"> Looking for : <?php echo $view_group["Gender"] ?></p>
            <p> <img src="/Home_pages/image/icons/meeting.png" alt="" width="25px"> Meetup point: <?php echo $view_group["Meetup_Point"] ?></p>
            <p> <img src="/Home_pages/image/icons/meeting.png" alt="" width="25px"> Meetup Time: <?php echo $view_group["Time"] ?></p>
            <p> <img src="/Home_pages/image/icons/talking.png" alt="" width="25px"> Language : BANGLA</p>
            <!-- <p> <img src="/Home_pages/image/icons/talking.png" alt="" width="25px"> Language : BANGLA</p> -->
        </div>


        <table>
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Transfort</th>
                    <th>Fare</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $view_group["Boarding_1"] ?></td>
                    <td><?php echo $view_group["Destination_1"] ?></td>
                    <td><?php echo $view_group["Transport_1"] ?></td>
                    <td><?php echo $view_group["Fare_1"] ?></td>
                </tr>
                <tr>
                    <td><?php echo $view_group["Boarding_2"] ?></td>
                    <td><?php echo $view_group["Destination_2"] ?></td>
                    <td><?php echo $view_group["Transport_2"] ?></td>
                    <td><?php echo $view_group["Fare_2"] ?></td>
                </tr>
                <tr>
                    <td><?php echo $view_group["Boarding_1"] ?></td>
                    <td><?php echo $view_group["Boarding_1"] ?></td>
                    <td><?php echo $view_group["Boarding_1"] ?></td>
                    <td><?php echo $view_group["Boarding_1"] ?></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Room Type</th>
                    <th>Day</th>
                    <th>Rent</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $view_group["Hotel"] ?></td>
                    <td><?php echo $view_group["Room_Type"] ?></td>
                    <td><?php echo $view_group["Day"] ?></td>
                    <td><?php echo $view_group["Rent"] ?></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Food</th>
                    <th>Other</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Expance</td>
                    <td><?php echo $view_group["Food_Expenditure"] ?></td>
                    <td><?php echo $view_group["Other_Cost"] ?></td>

                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>




</body>


</html>