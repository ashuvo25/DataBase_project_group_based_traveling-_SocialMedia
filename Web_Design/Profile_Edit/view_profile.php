<!DOCTYPE html>
<?php

include(__DIR__ . "/../DBconnection.php");

if (!isset($_SESSION['username'])) {
  header('location: Home_index.php');
  exit();
}
$username = $_SESSION['username'];
$link = select_profile_edit($username);
?>
<?php
$user = $username;

if (isset($_GET['username'])) {
  $user = $_GET['username'];
  //header('location: index.php');
}

$userInfo = select_profile_edit($user);

$groupInfo = host_group_view($user);
$onlymember=onlymember($user);


if ($userInfo) {
  // Assign the name from user information
  $Name = $userInfo["name"];
  $passwords = $userInfo["passwords"];
  $Email = $userInfo["email"];
  $Age = $userInfo["age"];
  // $Number = $userInfo["number"];
  // $Website = $userInfo["website"];
  // $Company = $userInfo["company"];
}

$conn->close();
?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Profile Page</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <!-- CSS -->
  <link rel="stylesheet" href="Home_style.css" />
</head>

<body>

  <div class="header__wrapper">
    <header>
      <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" class="header_imgs" />
    </header>
    <div class="cols__container">

      <div class="left__col">
        <div class="img__container">
          <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="nothing">
            <div class="upload">
              <img id="image" src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" width="120px" height="120px" class="prof_imgs" />

              <div class="leftRound" id="cancel" style="display: none;">
                <i class="fa fa-times"></i>
              </div>
              <div class="rightRound" id="confirm" style="display: none;">
                <i class="fa fa-check"></i>
              </div>
            </div>
          </form>
        </div>
        <h2><?php echo $Name ?></h2>
        <!-- <p><?php // echo $Company 
                ?></p> -->
        <p><?php echo $Email ?></p>

        <ul class="about">
          <li><span>4,073</span>Followers</li>
          <li><span>322</span>Following</li>
          <li><span>200,543</span>Hosted</li>
          <li><span>4</span>Tour</li>
        </ul>

        <div class="content">
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
            erat volutpat. Morbi imperdiet, mauris ac auctor dictum, nisl
            ligula egestas nulla.
          </p>

          <ul>
            <li><i class="fab fa-twitter"></i></li>
            <i class="fab fa-pinterest"></i>
            <i class="fab fa-facebook"></i>
            <i class="fab fa-dribbble"></i>
          </ul>
        </div>
      </div>
      <div class="right__col">
        <nav>
          <ul>
            <li><a id="showPhotos" href="#">Post</a></li>
            <li><a id="showPhotos" href="#">photos</a></li>
            <li><a id="showGroups" href="#">Hosting</a></li>
            <li><a id="showAllGroups" href="#">Groups</a></li>
          </ul>
          <button>Follow</button>
        </nav>

        <div class="photos" id="photo">
          <img src="adnan.jpg" alt="Photo" />
          <img src="adnan.jpg" alt="Photo" />
          <img src="adnan.jpg" alt="Photo" />
          <img src="adnan.jpg" alt="Photo" />
          <img src="adnan.jpg" alt="Photo" />
          <img src="adnan.jpg" alt="Photo" />
        </div>

        <div class="shop" id="group">
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
                  <a href="">
                    <p class="btn-area">
                      <!-- <a href=""><img src="add-group.png" class="icon_img" alt=""></a> -->
                      <span class="btn2"></span>
                    </p>
                  </a>
                  <p class="text"><?php
                                  $aboutTour = $group["About_Tour"];
                                  $words = str_word_count($aboutTour, 1);
                                  $limitedWords = implode(' ', array_slice($words, 0, 15));
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
                    Split costs: <span class="yellow">YES</span>
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

        <div class="shop" id="allgroup">
        <?php
          // Check if there are groups to display
          if ($onlymember) {
            // Loop through each group in the $groupInfo array
            foreach ($onlymember as $group) {
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
              $User_name =$user;
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
                  <a href="">

                    <p class="btn-area">
                      <!-- <a href=""><img src="add-group.png" class="icon_img" alt=""></a> -->
                      <span class="btn2"></span>
                    </p>
                  </a>
                  <p class="text"><?php
                                  $aboutTour = $group["About_Tour"];
                                  $words = str_word_count($aboutTour, 1);
                                  $limitedWords = implode(' ', array_slice($words, 0, 15));
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
                    Split costs: <span class="yellow">YES</span>
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

    </div>

  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var photosDiv = document.getElementById("photo");
      var groupsDiv = document.getElementById("group");
      var allGroupsDiv = document.getElementById("allgroup");

      var showPhotosLink = document.getElementById("showPhotos");
      var showGroupsLink = document.getElementById("showGroups");
      var showAllGroupsLink = document.getElementById("showAllGroups");

      // Initially, show only the photos div and hide the groups div and allgroup div
      photosDiv.style.display = "grid";
      groupsDiv.style.display = "none";
      allGroupsDiv.style.display = "none";

      // Add click event listeners
      showPhotosLink.addEventListener("click", function(event) {
        event.preventDefault();
        photosDiv.style.display = "grid";
        groupsDiv.style.display = "none";
        allGroupsDiv.style.display = "none";
      });

      showGroupsLink.addEventListener("click", function(event) {
        event.preventDefault();
        photosDiv.style.display = "none";
        groupsDiv.style.display = "grid";
        allGroupsDiv.style.display = "none";
      });

      showAllGroupsLink.addEventListener("click", function(event) {
        event.preventDefault();
        photosDiv.style.display = "none";
        groupsDiv.style.display = "none";
        allGroupsDiv.style.display = "grid";
      });
      
    });
  </script>

</body>

</html>