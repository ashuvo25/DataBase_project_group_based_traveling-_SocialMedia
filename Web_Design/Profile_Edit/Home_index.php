<!DOCTYPE html>
<?php

include(__DIR__. "/../DBconnection.php");

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
  header('location: index.php');
}

$userInfo = select_profile_edit($user);

$groupInfo = host_group_view($user);
$onlymember=onlymember($user);

$follower=countFollowing("follower",$user);
$following=countFollowing("following",$user);
$host=countFollowing("host",$user);
$total=countFollowing("total",$user);


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
            <li class="nav_list"> <a href="/Home_pages/Pagess/Friends/accpted_friend.php"><img src="/Home_pages/image/icons/networking.png" class="nav_icon"><span class="span_text">Network</span></a></li>
            <li class="nav_list"> <a href="/Web_Design/view_group/Group-page-design/index.php"><img src="/Home_pages/image/icons/group.png" class="nav_icon"><span class="span_text">Groups</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/deal.png" class="nav_icon"><span class="span_text">Sponsor</span></a></li>
            <li class="nav_list"> <a href="/Home_pages/Pagess/verification/veified.php"><img src="/Home_pages/image/icons/verified.png" class="nav_icon"><span class="span_text">Verification</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/comments.png" class="nav_icon"><span class="span_text">Message</span></a></li>
         </ul>
      </div>
      <div class="nav_right">

         <?php
         $name = $link['name'];
         ?>

         <!-- <div class="profile">
            <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
               <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" alt="" height="40px" width="40px" class="img_prof">
               <p><?php echo $name; ?></p>

            </a>
</div> -->
            <?php if ($link['verified'] == "YES") { ?>
            <div class="profile">
               <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
               <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" alt="" height="40px" width="40px" class="img_prof">
                  <p><?php echo $name; ?></p>
               </a>
            </div>
         <?php } else { ?>
            <div class="profile_1">
               <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
               <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" alt="" height="40px" width="40px" class="img_prof">
                  <p><?php echo $name; ?></p>
               </a>
            </div>
         <?php } ?>
         
      </div>
   </nav>

      <img src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" class="header_imgs" />
    </header>
    <div class="cols__container">

      <div class="left__col">
        <div class="img__container">
          <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id" value="nothing">
            <div class="upload">
            <!-- Home_pages\uploads -->
              <img id="image" src="<?php echo '/Home_pages/uploads/' . $link['image']; ?>" width="120px" height="120px" class="prof_imgs" />

              <div class="rightRound" id="upload">
                <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">

                <i class="fa fa-camera"></i>
              </div>
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
        <p  style =" color: #ffffff; "><?php echo $Email ?></p>

        <ul class="about" >
        <li  style =" color: #fff; "><span><?php echo $follower ?></span>Followers</li>
          <li  style =" color: #fff; "><span><?php echo $following  ?></span>Following</li>
          <li  style =" color: #fff; "><span><?php echo $host  ?></span>Hosted</li>
          <li  style =" color: #fff; "><span><?php echo $total ?></span>Tour</li>
        </ul>

        <div class="content">
          <p>
            <?php if($link['bio']){echo $link['bio'];} else{echo "........................................... No Bio ...........................................";}  ?>
          </p>

          <!-- <ul>
            <li><i class="fab fa-twitter"></i></li>
            <i class="fab fa-pinterest"></i>
            <i class="fab fa-facebook"></i>
            <i class="fab fa-dribbble"></i>
          </ul> -->
        </div>
      </div>
      <div class="right__col">
        <nav class="nav_iconss" >
          <ul>
            <li  style =" font-weight: bold; color: green;text-decoration: underline; "><a id="showPhotos" href="#">Post</a></li>
            <li  style =" font-weight: bold; text-decoration: underline;color: green; "><a id="showGroups" href="#">Hosting</a></li>
            <li  style =" font-weight: bold;text-decoration: underline;color: green; "><a id="showAllGroups" href="#">Groups</a></li>
            <li  style =" font-weight: bold;text-decoration: underline;color: green; "><a href="index.php">Edit</a></li>
          </ul>

          
        </nav>

        <div class="photos" id="photo">
          
         <?php

$user_id = 1;
// queary for featch data.

$sql = "SELECT * FROM post_table WHERE user_name_post_table = '$user'  ORDER BY date_time DESC";

$immag = "SELECT prof_text FROM signups" ;
$posts = mysqli_query($conn, $sql);

foreach ($posts as $post) : /////////////////////////////////for each 
   $post_id = $post["id"];
   


   /// ----profile image set-----------------          

?>

   <div class="post">
      <div class="prof">
         <div class="user_name">
            <!-- Small Profile section ------------------------ -->
            <div class="profimg">
               <?php
               $sql = "SELECT date_time, user_name_post_table ,locations FROM post_table WHERE id = $post_id";
               $result = $conn->query($sql);

               if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $c = $row['user_name_post_table'];
                  $d = $row['locations'];
               }



               $post_id = $post["id"];
               $immg = "SELECT prof_text FROM signups WHERE username = ?";
               $stmt = $conn->prepare($immg);
               $stmt->bind_param("s", $c);
               $stmt->execute();
               $result = $stmt->get_result();

               if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $imguel11 = 'uploads/' . $row['prof_text'];
               ?>

<img src="<?php echo '/Home_pages/uploads/' . $row['prof_text']; ?>" alt="" height="50px" width="50px" class="img_prof">

               <?php
               }
               ?>
            </div>

            <div class="date_timr">
               <?php
               $sql = "SELECT date_time, user_name_post_table ,locations FROM post_table WHERE id = $post_id";
               $result = $conn->query($sql);

               if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $a = $row['user_name_post_table'];
                  $b = $row['locations'];
                  echo "<a href='#' class='prof_name'>$a</a> <br>"; // Here comes the profile section;
               }
               $result = $conn->query($sql);
               if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $datetime = date("Y-m-d H:i:s", strtotime($row['date_time']));
                  echo "<p class = 'p_date'>$datetime  $b</p>";
               }
               ?>
            </div>
            <!-- Small Profile section   done ------------------------ -->

         </div>
      </div>

      <?php echo "<p class='p_textt'>" . $post['text_content'] . "</p>";
;
      $post_id = $post["id"];
      // ...
      if ($posts->num_rows > 0) {
         $row = $post;
         $imguel =  '/Home_pages/uploads/' . $row['file_name'];
         $imguel1 =  '/Home_pages/uploads/' . $row['file_name1'];
      ?>
      <div class="imgsss">
        
         <?php
         // Create an array of image URLs
         $imageURLs = array($imguel, $imguel1);
        
         foreach ($imageURLs as $imageURL) {
            if (!empty($imageURL)) {
             
               echo '<img src="' . $imageURL . '" alt="" height="300px" width="250px" class="img_posts">';
            }
         }
         echo"<br> ";
         ?>
        
        </div>
      <?php
      }
      ?> 
</div>
<?php endforeach; ?>
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
              <div class="box" style=" background: #072e43; color: green; ">
                <div class="img-container">
                <img alt="user photo" src="<?php echo '/Home_pages/uploads/' . $group['prof_text']; ?>">
                  <h4 class="Host" style=" color:chartreuse; "><?php echo "$User_name" ?></h4>
                </div>
                <div class="content">
                  <h2 style=" color:#fff; "><?php echo $Title ?></h2>
                  <h4>
                    <span class="Group_name" style=" color:#fff; "><?php echo "$From TO $to" ?></span> <br>
                    <span class="Date" style=" color:#fff; "><?php echo "$Start_date TO $End_date" ?></span>
                  </h4>
                  <a href="/Home_pages/Pagess/Trip/trip.php?groupid=<?php echo $Group_ID; ?>">
                    <p class="btn-area">
                      <!-- <a href=""><img src="add-group.png" class="icon_img" alt=""></a> -->
                      <span class="btn2">Dashboard</span>
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
              $host_user_name=$group["username"];

              $hostdetails=select_profile_edit($host_user_name);
          ?>
              <div class="box" style="background: #072e43;" >
                <div class="img-container">
                <img alt="user photo" src="<?php echo '/Home_pages/uploads/' . $hostdetails['image']; ?>">
                  <h4 class="Host" style=" color: yellow; "><?php $aboutTour = $hostdetails["name"] ;
                                  $words = str_word_count($aboutTour, 1);
                                  $limitedWords = implode(' ', array_slice($words, 0, 1));
                                  echo $limitedWords; ?></h4>
                </div>
                <div class="content">
                  <h2><?php echo $Title ?></h2>
                  <h4>
                    <span class="Group_name" style=" color: #fff; "><?php echo "$From TO $to" ?></span> <br>
                    <span class="Date" style=" color: #fff; "><?php echo "$Start_date TO $End_date" ?></span>
                  </h4>
                  <a href="/Home_pages/Pagess/Trip/user_trip.php?Group_ID=<?php echo $Group_ID; ?>">

                    <p class="btn-area">
                      <!-- <a href=""><img src="add-group.png" class="icon_img" alt=""></a> -->
                      <span class="btn2">Dashboard</span>
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
          $conn->close();
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
</script>
<script type="text/javascript">
    var userImage = document.getElementById('image').src; // Save the initial image source

    document.getElementById("fileImg").onchange = function () {
        var fileImg = document.getElementById("fileImg");
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]);
        document.getElementById("cancel").style.display = "block";
        document.getElementById("confirm").style.display = "block";
        document.getElementById("upload").style.display = "none";  
    }

    document.getElementById("cancel").onclick = function () {
        document.getElementById("image").src = userImage; // Restore the initial image source
        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";
        document.getElementById("upload").style.display = "block";
    }

    document.getElementById("confirm").onclick = function () {
        var fileImg = document.getElementById("fileImg").files[0];
        var formData = new FormData();
        formData.append("fileImg", fileImg);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "index_img.php"); // Update the URL to your server-side script
        xhr.onload = function () {
            if (xhr.status >= 200) {
                // Image successfully updated
                alert("Update Successfully"); // Display the server response
                window.location.href = window.location.href;
            } else {
                // Handle errors
                alert("Error updating image.");
            }
        };
        xhr.send(formData);
    }
</script>


<!-- SHUVO  -->
<!-- <script>
    // Wait for the DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
      // Get all the anchor elements in the navigation
      var navLinks = document.querySelectorAll('.nav_iconss a');

      // Add a click event listener to each anchor element
      navLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
          // Prevent the default link behavior
          event.preventDefault();

          // Remove the 'underline' class from all links
          navLinks.forEach(function(otherLink) {
            otherLink.classList.remove('underline');
          });

          // Add the 'underline' class to the clicked link
          link.classList.add('underline');
        });
      });
    });
  </script> -->
</body>

</html>