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

$group_id = 5;

if (isset($_GET["group_id"])) {
    $group_id = $_GET["group_id"];
}
$group_id = 0;

if (isset($_GET["Group_ID"])) {
    $group_id = $_GET["Group_ID"];
}
$view_group = group_details($group_id)

?>

<body>
    <div class="trip_main">
        <header>
            <p style="color: coral ;"> <a href="/Web_Design/Profile_Edit/Home_index.php" style=" text-decoration: none ; color: coral;"> <img src="/Home_pages/image/icons/next.png" alt="" width="25px" class="back_logo">BACK TO TRIPS</a>
            </p>


        </header>
        <div class="img_links">
            <div class="image_section">
                <div class="image_name">
                    <img src=" /Home_pages/uploads/' . $detail['prof_text'] . '" alt="" height="230px">
                    <p class="name"><?php echo $view_group["name"] ?></p>
                </div>

                <div class="text_side">
                    <h3><?php echo $view_group["Title"] ?> </h3>
                    <p class="date"><?php echo $view_group["Start_date"] . " to " . $view_group["End_date"] ?></p>
                    <p class="country"><img src="/Home_pages/uploads/" alt="" width="25px"> country</p>
                    <p class="about"><?php echo $view_group["About_Tour"] ?></p>
                </div>

            </div>

            <div class="links_section">
                <!-- <button class="icon_btn baa" ><img src="/Home_pages/image/icons/message.png" alt="" width="25px">Send Message</button>
                <button class="icon_btn baa1"><img src="/Home_pages/image/icons/click.png" alt="" width="25px">Join this trip</button>
                <button class="icon_btn baa2"><img src="/Home_pages/image/icons/comments.png" alt="" width="25px">Comment</button>
                <button class="icon_btn baa3"><img src="/Home_pages/image/icons/wave.png" alt="" width="25px">Send a wave</button>
                <button class="icon_btn baa"><img src="/Home_pages/image/icons/favourite.png" alt="" width="25px">Add to Favorites</button> -->
                <button class="icon_btn baa" id="messageButton"><img src="/Home_pages/image/icons/message.png" alt="" width="25px">Send Message</button>
                <button class="icon_btn baa2"><img src="/Home_pages/image/icons/comments.png" alt="" width="25px">Comment</button>


            </div>
            <div class="accpted">
                <p style=" text-decoration: underline;  margin-left: 50px; ">Team Members</p>

                <?php
                $details = group_member($view_group["Group_ID"]);

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
                        echo '</div>';
                        echo '</li>';
                    }

                    echo '</ul>';
                    echo '</div>';
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
                <tr style="background: #003554">
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
<script>
    // JavaScript code to handle button click
    document.getElementById('messageButton').addEventListener('click', function() {
        // Get the value you want to send (replace 'valueToBeSent' with the actual value)
        var valueToBeSent = '<?php echo $view_group["Group_ID"] ?>';

        // Navigate to another page and send the value as a query parameter
        window.location.href = '/Web_Design/Chat_Box/group_index.php?receiver=' + encodeURIComponent(valueToBeSent);
    });
</script>

</html>