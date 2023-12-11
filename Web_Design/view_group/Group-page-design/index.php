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
        
      $insertSql = "INSERT INTO group_member(group_id, member, request) VALUES (?, ?, ?)";
      $insertStmt = $conn->prepare($insertSql);

      // Create a variable for the "NO" value
      $requestValue = "NO";

      $insertStmt->bind_param("iss", $groupid, $USERNAME, $requestValue);

      if ($insertStmt->execute()) {
          $groupid = NULL;
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
<!-- ------------------------------------------ Shuuvo ADDD       -->
<div class="container" >

<div class="left_sidebar"> 
<a href="/Web_Design/create_group/Registration_Form/index.php" class="group_create" ><button class="group_creat" >Create Group</button> </a>
</div>
<!-- ------------------------Finish -->
    <div class="wrapper">
            <div class="left_sidebar1">
         <!-- Search box -->
         <div class="search_box">
            <div class="search">

               <form action="">
                  <input type="text" name="search_text" id="" placeholder="Search for anything" class="search_input">
                  <button type="submit" value="Search" class="search_button">Search</button>
               </form>
            </div>
         </div>
      </div>
      <!-- <input type="button" value="CREATE GROUP" class="h1" > -->
      <h3 class="h3" >groups</h3>
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

                        
                        $added_member_query = "SELECT COUNT(group_member.member) as Member FROM group_member, group_details
                        WHERE group_member.group_id = group_details.Group_ID and group_member.Group_ID= ?";
                        $added_member_stmt = $conn->prepare($added_member_query);
                        $added_member_stmt->bind_param("i", $Group_ID);
                        $added_member_stmt->execute();
                        $added_member_result = $added_member_stmt->get_result();

                        if ($added_member_result) {
                        $added_member_row = $added_member_result->fetch_assoc();
                        $added_member = $added_member_row['Member'];

                        if ($group['Member'] > intval($added_member))  {
                            // Your comparison logic here

            ?>
                            <div class="box">
                                <div class="img-container">
                                    <img alt="user photo" src="<?php echo '/Home_pages/uploads/' . $group['prof_text']; ?>">
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
                                        Member: <span class="yellow"><?php echo $group["Member"] . "/" . $added_member; ?></span>
                                        <img src="destination.png" class="text_icon_img_2" alt="">
                                        Type of journey: <span class="yellow"><?php echo $Type_of_journey ?></span>
                                    </p>
                                </div>
                            </div>

            <?php
                        }
                    }
                }
            } else {
                    echo "No groups to display.";
                }
                ?>
           
        </div>
        </div>

        <div class="right_sidebar">
         <div class="imp-links">

            <a href=""><img src="/Home_pages/image/icons/newspaper.png" class="friend">&nbsp Latest Update</a>
            <a href=""><img src="/Home_pages/image/icons/friends.png" class="friend">&nbsp Friends</a>
            <a href=""><img src="/Home_pages/image/icons/group.png" class="friend">&nbsp Groups</a>
            <a href=""><img src="/Home_pages/image/icons/activity.png" class="friend">&nbsp Activity</a>
            <a href=""><img src="/Home_pages/image/icons/travel-bag.png" class="friend">&nbsp Travel</a>


            <span class="more-options">
               <a href="google"><img src="/Home_pages/image/icons/memoris.png" class="friend">&nbsp Memoris</a>
               <a href=""><img src="/Home_pages/image/icons/deal.png" class="friend">&nbsp Promotions</a>
               <a href=""><img src="/Home_pages/image/icons/events.png" class="friend">&nbsp Events</a>
               <a href=""><img src="/Home_pages/image/icons/feedback.png" class="friend">&nbsp Feedback</a>
               <a href=""><img src="/Home_pages/image/icons/travel-bag.png" class="friend">&nbsp Todo</a>
            </span>

         </div>
         <span class="more">
            See More... &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
         </span>

         <!-- extra links ------------------------------------------------------------------------------------------- -->
         <div class="extra">
            <p class="p_extra"><br>Your Shortcuts</p>

            <div class="extra_links">
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
               a <br>
            </div>
         </div>

         <div class="short-cut">
            <p></p>
            <a href=""><img src="/Home_pages/image/icons/settings1.png" class="icon_setting">&nbsp Settings</a>
            <a href="/login.php"><img src="/Home_pages/image/icons/log-out.png" class="icon_setting">&nbsp Log Out</a>
         </div>

      </div>
    </div>




    <script>
      document.addEventListener('DOMContentLoaded', function() {
         const moreButton = document.querySelector('.more');
         const moreOptions = document.querySelector('.more-options');

         moreButton.addEventListener('click', function() {
            moreOptions.classList.toggle('more-options--show');
            moreButton.textContent = moreOptions.classList.contains('more-options--show') ? "See Less..." : "See More...";
         });
      });
   </script>
</body>

</html>