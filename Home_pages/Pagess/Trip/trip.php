

<!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> </title>
    <link rel="stylesheet" href="trip.css">
</head>
<?php
include(__DIR__.'/../../../Web_Design/DBconnection.php');

$group_id ='';

if (isset($_GET["groupid"])) {
    $group_id = $_GET["groupid"];
}

$view_group = group_details($group_id)



?>

<body>
    <div class="trip_main">
        <header>
            <p> <a href="#"> <img src="/Home_pages/image/icons/next.png" alt="" width="25px" class="back_logo">BACK TO TRIPS</a>
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
                <button class="icon_btn baa" id="messageButton"><img src="/Home_pages/image/icons/message.png" alt="" width="25px">Send Message</button>
                <button class="icon_btn baa2"><img src="/Home_pages/image/icons/comments.png" alt="" width="25px">Comment</button>
                <button class="icon_btn baa1"><img src=/Home_pages/image/icons/click.png" alt="" width="25px">Edit Group</button>
                <button class="icon_btn baa3" id="requestButton"><img src="/Home_pages/image/icons/wave.png" alt="" width="25px">Request</button>


            </div>
            <?php
            $details = add_request($view_group["Group_ID"]);

            if ($details !== null) {
                echo '<div class="notification">';
                echo '<ul class="friend-request-list">';

                foreach ($details as $detail) {
                    echo '<li class="friend-request">';
                    echo '<div class="friend-request-header">';
                    echo '<div class="friend-request-profile">';
                    echo '<img src="' . $detail['profile_photo'] . '" alt="Profile Photo">';
                    echo '</div>';
                    echo '<div class="friend-request-info">';
                    echo '<p>' . $detail['name'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="friend-request-buttons">';
                    echo '<button class="accept-button">Accept</button>';
                    echo '<button class="reject-button">Reject</button>';
                    echo '</div>';
                    echo '</li>';
                }

                echo '</ul>';
                echo '</div>';
            } else {
                echo 'No friend requests.';
            }
            ?>

        </div>

        <div class="extras_item">
            <p> <img src="/Home_pages/image/icons/split.png" alt="" width="25px"> split costs : yes</p>
            <p> <img src="/Home_pages/image/icons/money-bag.png" alt="" width="25px"> Budget : <?php echo $view_group["Fare_1"] + $view_group["Fare_2"] + $view_group["Day"] * $view_group["Rent"] + $view_group["Other_Cost"] ?></p>
            <p> <img src="/Home_pages/image/icons/journey_type.png" alt="" width="25px"> Type Of Journey :<?php echo $view_group["Type_of_journey"] ?></p>
            <p> <img src="/Home_pages/image/icons/sex.png" alt="" width="25px"> Looking for : <?php echo $view_group["Gender"] ?></p>
            <p> <img src="/Home_pages/image/icons/meeting.png" alt="" width="25px"> Meetup point: <?php echo $view_group["Meetup_Point"] ?></p>
            <p> <img src="/Home_pages/image/icons/meeting.png" alt="" width="25px"> Meetup Time: time ?></p>
            <p> <img src="/Home_pages/image/icons/talking.png" alt="" width="25px"> Language : BANGLA</p>
            <p> <img src="/Home_pages/image/icons/talking.png" alt="" width="25px"> Language : BANGLA</p>
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







































<!-- <!DOCTYPE html>
<html>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> </title>
    <link rel="stylesheet" href="trip.css">
</head>

<body>
    <div class="trip_main">
        <header>
            <p> <a href="#"> <img src="/Home_pages/image/icons/next.png" alt="" width="25px" class="back_logo">BACK TO TRIPS</a>
            <h4> I am seeking to go buddy to china</h4>
            </p>


        </header>
        <div class="img_links">
            <div class="image_section">
                <div class="image_name">
                    <img src="/Home_pages/uploads/0123.jpg" alt="" height="230px">
                    <p class="name">LOVE.LOVE</p>
                </div>

                <div class="text_side">
                    <h3>NAME </h3>
                    <p class="date" >15.12.2023 - 19.12.2023</p>
                    <p class="country" ><img src="/Home_pages/image/icons/flag.png"  alt="" width="25px" > country</p>
                    <p class="about" >Lorem ipsum dolor sit amet consectetur,
                        a voluptatibus molestias illo eveniet
                        quidem minima?</p>
                </div>

            </div>

            <div class="links_section">
                <button class="icon_btn baa" ><img src="/Home_pages/image/icons/message.png" alt="" width="25px">Send Message</button>
                <button class="icon_btn baa1"><img src="/Home_pages/image/icons/click.png" alt="" width="25px">Join this trip</button>
                <button class="icon_btn baa2"><img src="/Home_pages/image/icons/comments.png" alt="" width="25px">Comment</button>
                <button class="icon_btn baa3"><img src="/Home_pages/image/icons/wave.png" alt="" width="25px">Send a wave</button>
                <button class="icon_btn baa"><img src="/Home_pages/image/icons/favourite.png" alt="" width="25px">Add to Favorites</button>
            </div>
        </div>

        <div class="extras_item">
            <p> <img src="/Home_pages/image/icons/split.png" alt="" width="25px"> split costs : yes</p>
            <p> <img src="/Home_pages/image/icons/money-bag.png" alt="" width="25px"> Budget : 1000$</p>
            <p> <img src="/Home_pages/image/icons/journey_type.png" alt="" width="25px"> Type Of Journey : BUS</p>
            <p> <img src="/Home_pages/image/icons/sex.png" alt="" width="25px"> Looking for : MALE</p>
            <p> <img src="/Home_pages/image/icons/meeting.png" alt="" width="25px"> Meet Before Trip: CHOLO GHURI</p>
            <p> <img src="/Home_pages/image/icons/meeting.png" alt="" width="25px"> Meet Before Trip: CHOLO GHURI</p>
            <p> <img src="/Home_pages/image/icons/talking.png" alt="" width="25px"> Language : BANGLA</p>
            <p> <img src="/Home_pages/image/icons/talking.png" alt="" width="25px"> Language : BANGLA</p>
        </div>
    </div>
</body>

</html> -->




