<!DOCTYPE html>

<?php
include(__DIR__.'/../../DBconnection.php');
?>

<?php
$groupInfo = group_view();
$username = $_SESSION['username'];
$link = select_profile_edit($username);

?>


<?php
if (isset($_GET['variable1'])) {
    
    $USERNAME = $_SESSION['username'];


    $groupid = (int)$_GET['variable1'];

   
    $checkSql = "SELECT * FROM `group_member` WHERE `group_id` = ? AND `member` = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("is", $groupid, $USERNAME);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        
        echo "<script>alert('Your request has already been sent.');</script>";
    } else {
        
        $insertSql = "INSERT INTO `group_member`(`group_id`, `member`) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("is", $groupid, $USERNAME);

        if ($insertStmt->execute()) {
            
            $groupid =NULL;
            header('Location: index.php');
        } else {
            echo "Error: " . $insertSql . "<br>" . $insertStmt->error;
        }

        
        $insertStmt->close();
    }

    
    $checkStmt->close();
}
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Responsive Shopping Cart design</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    
<nav>
      <div class="nav_left">
         <div class="logo">
            <h1 class="title">
               Forest MeN
               <div class="logo-container">
                  <div class="aurora"></div>

               </div>
            </h1>
            <p class="subtitie">Made Trip With Us!</p>
         </div>
         <ul>
            <li class="nav_list"> <a href="/Home_pages/home.php"><img src="/Home_pages/image/icons/homes.png" class="nav_icon"><span class="span_text">Home</span></a></li>
            <li class="nav_list"> <a href="/Home_pages/Pagess/Friends/friends.php"><img src="/Home_pages/image/icons/networking.png" class="nav_icon"><span class="span_text">Network</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/group.png" class="nav_icon"><span class="span_text">Groups</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/deal.png" class="nav_icon"><span class="span_text">Sponsor</span></a></li>
            <li class="nav_list"> <a href="/Home_pages/Pagess/verification/veified.php"><img src="/Home_pages/image/icons/verified.png" class="nav_icon"><span class="span_text">Verification</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/comments.png" class="nav_icon"><span class="span_text">Message</span></a></li>
         </ul>
      </div>
      <div class="nav_right">
         <!-- login_signup_page\Web_Design\Profile_Edit\Home_index.php -->
         <?php
         $name = $link['name'];
         ?>
         <!-- <img src="/Home_pages/uploads/" alt=""> -->
      <!-- Home_pages\uploads -->
         <div class="profile">
            <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
               <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" alt="" height="40px" width="40px" class="img_prof">
               <p><?php echo $name; ?></p>
               
            </a>
         </div>
      </div>
   </nav>

    <div class="wrapper">
      <input type="button" value="CREATE GROUP" class="h1" >
        <div class="project">
          
                <?php
                // Check if there are groups to display
                if ($groupInfo) {
                    // Loop through each group in the $groupInfo array
                    foreach ($groupInfo as $group) {
                        // Access individual attributes for each group
                        $Group_ID = $group["Group_ID"];
                        $Title = $group["Title"];
                        $From = $group["FromLocation"];
                        $to = $group["ToLocation"];
                        $Start_date = $group["Start_date"];
                        $End_date = $group["End_date"];
                        $Gender = $group["Gender"];
                        $Type_of_journey = $group["Type_of_journey"];
                        $Itinerary = $group["Itinerary"];
                        $Mobile_number = $group["Mobile_number"];
                        $Privacie = $group["Privacie"];
                        $User_name = $group["User_Name"];
                ?>
                        <div class="box">
                            <div class="img-container">
                                <img alt="user photo" src="2.jpg">
                                <h4 class="Host"><?php echo "$User_name" ?></h4>
                            </div>
                            <div class="content">
                                <h2><?php echo $Title ?></h2>
                                <h4>
                                    <span class="Group_name"><?php echo "$From TO $to" ?></span> <br>
                                    <span class="Date"><?php echo "$Start_date TO $End_date" ?></span>
                                </h4>
                                <p class="btn-area">
                                    <a href="index.php?variable1= <?php echo  $group["Group_ID"]; ?>" id="requestButton">
                                        <img src="add-group.png" class="icon_img" alt="">
                                    </a>
                                    <span class="btn2">Request</span>
                                </p>


                                <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                <script>
                                    document.getElementById('requestButton').addEventListener('click', function() {
                                        // Get the values of the variables you want to send
                                        var variable1 = "<?php echo  $group["Group_ID"]; ?>";

                                        // Make an AJAX request
                                        $.ajax({
                                            type: 'POST',
                                            url: 'index.php', // Replace with the actual path to your PHP script
                                            data: {
                                                variable1: variable1
                                            },
                                            success: function(response) {
                                                // Handle the response from the server
                                                console.log(response);
                                            },
                                            error: function(error) {
                                                // Handle errors
                                                console.error('Error:', error);
                                            }
                                        });
                                    }); -->
                                </script>
                                <p class="text"><?php
                                                $aboutTour = $group["About_Tour"];
                                                $words = str_word_count($aboutTour, 1);
                                                $limitedWords = implode(' ', array_slice($words, 0, 10));
                                                echo $limitedWords;
                                                ?></p>
                                <p class="text">
                                    <img src="gender.png" class="text_icon_img" alt="">
                                    Looking for: <span class="yellow"><?php echo $Gender ?></span>
                                    <img src="transportation.png" class="text_icon_img_2" alt="">
                                    Travel By: <span class="yellow"><?php echo $group["Transport_1"] ?></span>
                                </p>
                                <p class="text">
                                    <img src="add-group.png" class="text_icon_img" alt="">
                                    Privacy: <span class="yellow"> <?php echo $group['Privacie']; ?> </span>
                                    <img src="budget.png" class="text_icon_img_2" alt="">
                                    Budget: <span class="yellow"><?php echo $group["Fare_1"] + $group["Fare_2"] + $group["Day"] * $group["Rent"] + $group["Other_Cost"] ?></span>
                                </p>
                                <p class="text">
                                    <img src="people.png" class="text_icon_img" alt="">
                                    Member: <span class="yellow">5</span>
                                    <img src="destination.png" class="text_icon_img_2" alt="">
                                    Type of journey: <span class="yellow"><?php echo $Type_of_journey ?></span>
                                </p>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No groups to display.";
                }
                ?>
           
        </div>
    </div>
</body>

</html>