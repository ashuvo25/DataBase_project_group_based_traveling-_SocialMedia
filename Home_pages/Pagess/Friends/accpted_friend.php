<?php

include(__DIR__ . '/../../../Web_Design/DBconnection.php');



if (!isset($_SESSION['username'])) {
   header('Location: friends.php');
   exit();
}
$username = $_SESSION['username'];
$link = select_profile_edit($username);
?>
<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   if (isset($_POST['following']) && isset($_POST['follower'])) {
      $following = $_POST['following'];
      $follower = $_POST['follower'];

      // Validate and sanitize input if needed

      // Call the insertConnection function
      $success = deleteConnection($following, $follower);

      // Send a response back to the JavaScript
      header('Content-Type: application/json');
      echo json_encode(['success' => $success]);
   }
   if (isset($_POST['fing']) && isset($_POST['fer'])) {
      $following = $_POST['fing'];
      $follower = $_POST['fer'];

      // Validate and sanitize input if needed

      // Call the insertConnection function
      $success = insertConnection($following, $follower);

      // Send a response back to the JavaScript
      header('Content-Type: application/json');
      echo json_encode(['success' => $success]);
   }
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $following = $_POST['fing'];
//    $follower = $_POST['fer'];

//    // Validate and sanitize input if needed

//    // Call the insertConnection function
//    $success = insertConnection($following, $follower);

//    // Send a response back to the JavaScript
//    header('Content-Type: application/json');
//    echo json_encode(['success' => $success]);
// }




if (isset($_GET['search_text'])) {
   $searchText = $_GET['search_text'];
   // echo "Search Text: " . $searchText . "<br>"; // Debugging statement
   $sql = "SELECT * FROM signups WHERE username LIKE '%$searchText%' ";
   // echo "SQL Query: " . $sql . "<br>"; // Debugging statement

   $searchResults = mysqli_query($conn, $sql);

   if (!$searchResults) {
      die("Query Error: " . mysqli_error($conn)); // Debugging statement
   }
} else {
   $searchResults = [];
}




?>

<!DOCTYPE html>
<html>

<head>
   <meta charset='UTF-8'>
   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <title> </title>
   <link rel="stylesheet" href="friends.css">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="https://use.fontawesome.com/fe459689b4.js"></script>



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
            <li class="nav_list"> <a href="/Home_pages/Pagess/Friends/accpted_friend.php"><img src="/Home_pages/image/icons/networking.png" class="nav_icon"><span class="span_text">Network</span></a></li>
            <li class="nav_list"> <a href="/Web_Design/view_group/Group-page-design/index.php"><img src="/Home_pages/image/icons/group.png" class="nav_icon"><span class="span_text">Groups</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/deal.png" class="nav_icon"><span class="span_text">Sponsor</span></a></li>
            <li class="nav_list"> <a href="/Home_pages/Pagess/verification/veified.php"><img src="/Home_pages/image/icons/verified.png" class="nav_icon"><span class="span_text">Verification</span></a></li>
            <li class="nav_list"> <a href="/Web_Design/Chat_Box/index.php? receiver=<?php $_SESSION["username"] ?>"><img src="/Home_pages/image/icons/comments.png" class="nav_icon"><span class="span_text">Message</span></a></li>
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



   <div class="container">

      <div class="left_sidebar">
         <!-- Wrap your form with a <form> tag and give it an id -->
         <form id="searchForm" class="navbar-form navbar-left" action="" method="get">
            <div class="input-group">
               <input type="text" class="form-control" name="search_text" id="searchbar" autocomplete="off">
            </div>
            <div class="input-group-btn">
               <button class="btn btn-default" type="submit">
                  <i class="fa fa-search"></i>
               </button>
            </div>
         </form>

         <div class="friend_req">
            <header class="req">Notification</header>
            <div class="requests">

               <?php
               $details = getUsersWhoFollowMe($_SESSION['username']);

               if ($details !== null) {
                  echo '<div class="notification">';
                  echo '<ul class="friend-request-list">';
                  $count = 0;

                  foreach ($details as $detail) {
                     echo '<li class="friend-request1">';
                     echo '<div class="friend-request-header">';
                     echo '<div class="friend-request-profile">';
                     echo '<img src="/Home_pages/uploads/' . $detail['prof_text'] . '" alt="" height="40px" width="40px" class="img_prof">';
                     echo '</div>';
                     echo '<div class="friend-request-info">';
                     echo '<p style="color:#fff">' . $detail['name'] . ' started following you</p>';
                     echo '</div>';
                     echo '</div>';
                     echo '</li>';

                     $count++; 

               
                     if ($count >= 5) {
                         break; 
                     }

                  }

                  echo '</ul>';
                  echo '</div>';
               } else {
                  echo 'No friend requests.';
               }
               ?>

            </div>
         </div>
      </div>
      <!-- ----------------------------------------------div 1    ------------------------------------- -->
      <div class="main_sidebar" id="1" style="display: block;">
         <?php
         if (!empty($searchResults)) {

            foreach ($searchResults as $result) {

               $userId = $result['user_id'];
               $userNamer = $result['username'];
               $userImage = $result['prof_text'];

               $userEmail = $result['verified_mail'];

               $emailParts = explode('@bscse.', $userEmail);
               $domain = isset($emailParts[1]) ? $emailParts[1] : '';

               // Check if the domain is in the univ_domain table
               $sql = "SELECT university FROM univ_domain WHERE domain = '$domain'";
               $universityResult = mysqli_query($conn, $sql);

               if ($universityResult) {
                  $universityData = mysqli_fetch_assoc($universityResult);
                  $universityName = isset($universityData['university']) ? $universityData['university'] . ' , Verified' : 'Not verified';
               } else {
                  $universityName = 'Not verified';
               }
               // Home_pages\uploads
               if ($userNamer != $username) {
                  echo '<div class="search-result">';
                  echo '<div class = "section_req">';
                  echo "<a href='/Web_Design/Profile_Edit/view_profile.php?username=$userNamer' class='req_link'>";

                  echo '<img src="/Home_pages/uploads/' . $userImage . '"  width="50px" height="50px" class="img_friend" >';
                  echo '<div class = "section_name">';
                  echo '<span>' . $userNamer . '</span>';
                  echo '<p class ="req_email" >' .  $universityName . '</p>';
                  echo '</a>';
                  echo '</div>';
                  echo '</div>';
                  // Add this part inside your loop where you display search results
                  $check = checkIfUsersFollowEachOther($_SESSION["username"], $userNamer);
                  if ($check) {
                     echo '<a href="/Web_Design/Chat_Box/index.php?receiver=' . $userNamer . '">';

                     echo '<button class="connect-button">Message</button>';

                     echo '</a>';
                  } else {
                     echo '<button class="connect-button" onclick="sendFriendRequest(\'' .  $userNamer . '\')">Connect</button>';
                  }


                  echo '</div>';
               }
            }
         } else {
            //$query = "SELECT username, verified_mail, prof_text FROM signups";
            $query = "SELECT DISTINCT s.username, s.verified_mail, s.prof_text
            FROM signups s
            LEFT JOIN connection c ON (s.username = c.following OR s.username = c.follower) AND c.follower = ?
            WHERE c.following IS NULL and s.username != ?";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $_SESSION["username"], $_SESSION["username"]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);


            if ($result) {
               // Display the list of users
               while ($row = mysqli_fetch_assoc($result)) {
                  $userEmail = $row['verified_mail'];

                  $emailParts = explode('@bscse.', $userEmail);
                  $domain = isset($emailParts[1]) ? $emailParts[1] : '';

                  // Check if the domain is in the univ_domain table
                  $sql = "SELECT university FROM univ_domain WHERE domain = '$domain'";
                  $universityResult = mysqli_query($conn, $sql);

                  if ($universityResult) {
                     $universityData = mysqli_fetch_assoc($universityResult);
                     $universityName = isset($universityData['university']) ? $universityData['university'] . ' , Verified' : 'Not verified';
                  } else {
                     $universityName = 'Not verified';
                  }
                  //   $userId = $row['user_id'];

                  // Output specific columns from the 'signups' table
                  echo '<div class="search-result">';
                  $hell = $row['username'];
                  echo '<div class="section_req">';
                  echo '<img src="/Home_pages/uploads/' . $row['prof_text'] . '" width="50px" height="50px" class="img_friend">';
                  echo "<a href='/Web_Design/Profile_Edit/view_profile.php?username=$hell' class='req_link'>";



                  echo '<div class="user-detail">';
                  echo '<span class="section_name" style="text-decoration: underline;color:#00c2ff">' . $row['username'] . '</span>';

                  echo '<p class="req_email">' . $universityName . '</p>';
                  echo '</div>';


                  echo '</a>';
                  echo '</div>';
                  // Connect button
                  echo '<button class="connect-button" onclick="sendFriendRequest(\'' .  $row['username'] . '\')">Follow</button>';

                  echo '</div>';
               }
            }
         }
         ?>
      </div>

      <!-- ----------------------------------div 2------------------------------------------ -->
      <div class="main_sidebar" id="2" style="display: none;">
         <?php

         //$query = "SELECT username, verified_mail, prof_text FROM signups";
         $query = "SELECT DISTINCT s.username, s.verified_mail, s.prof_text
            FROM signups s
            LEFT JOIN connection c ON s.username = c.following
            WHERE c.follower = ? AND s.username != ?";

         $stmt = mysqli_prepare($conn, $query);
         mysqli_stmt_bind_param($stmt, "ss", $_SESSION["username"], $_SESSION["username"]);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         if ($result) {
            // Display the list of users
            while ($row = mysqli_fetch_assoc($result)) {
               $userEmail = $row['verified_mail'];

               $emailParts = explode('@bscse.', $userEmail);
               $domain = isset($emailParts[1]) ? $emailParts[1] : '';

               // Check if the domain is in the univ_domain table
               $sql = "SELECT university FROM univ_domain WHERE domain = '$domain'";
               $universityResult = mysqli_query($conn, $sql);

               if ($universityResult) {
                  $universityData = mysqli_fetch_assoc($universityResult);
                  $universityName = isset($universityData['university']) ? $universityData['university'] . ' , Verified' : 'Not verified';
               } else {
                  $universityName = 'Not verified';
               }
               //   $userId = $row['user_id'];

               // Output specific columns from the 'signups' table
               echo '<div class="search-result">';
               $huu = $row['username'];
               echo '<div class="section_req">';
               echo '<img src="/Home_pages/uploads/' . $row['prof_text'] . '" width="50px" height="50px" class="img_friend">';
               echo "<a href='/Web_Design/Profile_Edit/view_profile.php?username=$huu' class='req_link'>";



               echo '<div class="user-detail">';
               echo '<span class="section_name" style="text-decoration: underline;color:#00c2ff">' . $row['username'] . '</span>';

               echo '<p class="req_email">' . $universityName . '</p>';
               echo '</div>';


               echo '</a>';
               echo '</div>';
               // Connect button
               echo '<button class="connect-button" onclick="removeFriendRequest(\'' .  $row['username'] . '\')">Following</button>';

               echo '</div>';
            }
         }

         ?>
      </div>

      <!-- ------------------------------------------div  3 ------------------------ -->
      <div class="main_sidebar" id="3" style="display: none;">
         <?php
         //$query = "SELECT username, verified_mail, prof_text FROM signups";
         $query = "SELECT DISTINCT s.username, s.verified_mail, s.prof_text
               FROM signups s
               LEFT JOIN connection c ON s.username = c.follower
               WHERE c.following = ? ";

         $stmt = mysqli_prepare($conn, $query);
         mysqli_stmt_bind_param($stmt, "s", $_SESSION["username"]);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         if ($result) {
            // Display the list of users
            while ($row = mysqli_fetch_assoc($result)) {
               $userEmail = $row['verified_mail'];

               $emailParts = explode('@bscse.', $userEmail);
               $domain = isset($emailParts[1]) ? $emailParts[1] : '';

               // Check if the domain is in the univ_domain table
               $sql = "SELECT university FROM univ_domain WHERE domain = '$domain'";
               $universityResult = mysqli_query($conn, $sql);

               if ($universityResult) {
                  $universityData = mysqli_fetch_assoc($universityResult);
                  $universityName = isset($universityData['university']) ? $universityData['university'] . ' , Verified' : 'Not verified';
               } else {
                  $universityName = 'Not verified';
               }
               //   $userId = $row['user_id'];

               // Output specific columns from the 'signups' table
               echo '<div class="search-result">';
               $hum = $row['username'];
               echo '<div class="section_req">';
               echo '<img src="/Home_pages/uploads/' . $row['prof_text'] . '" width="50px" height="50px" class="img_friend">';
               echo "<a href='/Web_Design/Profile_Edit/view_profile.php?username=$hum' class='req_link'>";



               echo '<div class="user-detail">';
               echo '<span class="section_name" style="text-decoration: underline;color:#00c2ff">' . $row['username'] . '</span>';

               echo '<p class="req_email">' . $universityName . '</p>';
               echo '</div>';


               echo '</a>';
               echo '</div>';
               // Connect button
               $check = checkIfUsersFollowEachOther($_SESSION["username"], $row['username']);
               if ($check) {
                  echo '<a href="/Web_Design/Chat_Box/index.php?receiver=' . $row['username'] . '">';

                  echo '<button class="connect-button">Message</button>';

                  echo '</a>';
               } else {
               echo '<button class="connect-button" onclick="sendFriendRequest(\'' .  $row['username'] . '\')">Followers</button>';
               }

               echo '</div>';
            }
         }

         ?>
      </div>

      <!-- -----------------------------------Right Side------------------------------------------- -->
      <div class="right_sidebar">
         <div class="imp-links">



            <a href=""><img src="/Home_pages/image/icons/newspaper.png" class="friend">&nbsp Latest Update</a>

            <a href="#" id="followersButton"><img src="/Home_pages/image/icons/group.png" class="friend">&nbsp Followers</a>
            <a href="#" id="followingButton"><img src="/Home_pages/image/icons/group.png" class="friend">&nbsp Following </a>

            <a href=""><img src="/Home_pages/image/icons/activity.png" class="friend">&nbsp Activity</a>
            <a href=""><img src="/Home_pages/image/icons/travel-bag.png" class="friend">&nbsp Travel</a>

<!--          edited------------------- -->
            <span class="more-options1">
               <a href="google"><img src="/Home_pages/image/icons/memoris.png" class="friend">&nbsp Memoris</a>
               <a href=""><img src="/Home_pages/image/icons/deal.png" class="friend">&nbsp Promotions</a>
               <a href=""><img src="/Home_pages/image/icons/events.png" class="friend">&nbsp Events</a>
               <a href=""><img src="/Home_pages/image/icons/feedback.png" class="friend">&nbsp Feedback</a>
               <a href=""><img src="/Home_pages/image/icons/travel-bag.png" class="friend">&nbsp Todo</a>
            </span>

         </div>
         <!-- <span class="more">
            See More... &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
         </span> -->

         <!-- extra links ------------------------------------------------------------------------------------------- -->
         <!-- <div class="extra">
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
            </div>
         </div> -->

         <div class="short-cut">
            <p></p>
            <a href=""><img src="/Home_pages/image/icons/settings1.png" class="icon_setting">&nbsp Settings</a>
            <a href="/login.php"><img src="/Home_pages/image/icons/log-out.png" class="icon_setting">&nbsp Log Out</a>
         </div>
      </div>


   </div>

   <!-- <script>
      document.addEventListener('DOMContentLoaded', function() {
         const moreButton = document.querySelector('.more');
         const moreOptions = document.querySelector('.more-options');

         moreButton.addEventListener('click', function() {
            moreOptions.classList.toggle('more-options--show');
            moreButton.textContent = moreOptions.classList.contains('more-options--show') ? "See Less..." : "See More...";
         });
      });
   </script> -->

   <script>
      function handleSearch() {
         var searchText = document.getElementById('searchbar').value;
         console.log("Search Text:", searchText);
         var mainSidebar = document.querySelector('.main_sidebar');
         mainSidebar.innerHTML = ""; // Clear previous content

         //   <?php
               //   if (!empty($searchResults)) {
               //       foreach ($searchResults as $result) {
               //           // Assuming $result is an associative array with user information
               //           $userId = $result['user_id'];
               //           $userName = $result['username'];
               //           $userImage = $result['prof_text'];

               //           echo "mainSidebar.innerHTML += '<div class=\"search-result\">';";
               //           echo "mainSidebar.innerHTML += '<img src=\"/path/to/images/" . $userImage . "\" alt=\"User Image\" width=\"25px\" height=\"25px\">';";
               //           echo "mainSidebar.innerHTML += '<span>" . $userName . "</span>';";
               //           echo "mainSidebar.innerHTML += '<button class=\"connect-button\" onclick=\"connect(" . $userId . ")\">Connect</button>';";
               //           echo "mainSidebar.innerHTML += '</div>';";
               //       }
               //   } else {
               //       echo "mainSidebar.innerHTML = 'No results found.';";
               //   }
               //   
               ?>
      }
      document.getElementById('searchbar').addEventListener('keyup', function(event) {
         if (event.key === 'Enter') {
            handleSearch();
         }
      });
   </script>
   <script>
      // function sendFriendRequest(receiverId) {
      //    // Use AJAX to send friend request to the server
      //    $.ajax({
      //       url: 'accpted_friends.php', // Replace with the actual filename
      //       type: 'POST',
      //       data: {
      //          action: 'sendFriendRequest',
      //          receiverId: receiverId
      //       },
      //       success: function(response) {
      //          // Display a notification to the sender
      //          if (response.success) {
      //             swal("Friend Request Sent!", "Your friend request has been sent.", "success");
      //          } else {
      //             swal("Error", "Something went wrong. Please try again.", "error");
      //          }
      //       }
      //    });
      // }

      function handleFriendRequest(action, requestId) {
         // Use AJAX to send accept/reject action to the server
         $.ajax({
            url: 'accpted_friends.php', // Replace with the actual filename
            type: 'POST',
            data: {
               action: action,
               requestId: requestId
            },
            success: function(response) {
               // Display a notification to the receiver
               if (response.success) {
                  swal("Request Updated!", "Friend request status has been updated.", "success");
               } else {
                  swal("Error", "Something went wrong. Please try again.", "error");
               }
            }
         });
      }
   </script>

   <!-- <script>
      function sendFriendRequest(followingname) {
         var url = 'accpted_friend.php'; // Assuming this file is friend.php

         $.ajax({
            type: 'POST',
            url: url,
            data: {
               following: followingname,
               follower: '<?php echo $_SESSION['username']; ?>'
            },
            success: function(response) {
               if (response.success) {
                  alert('Remove successfull.');
               } else {
                  alert('Remove fail');
               }
            },
            error: function() {
               alert('Error sending connection request.');
            }
         });
      }
   </script> -->

   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Add event listener for Followers button
         document.getElementById('followersButton').addEventListener('click', function() {
            showSection('3');
         });

         // Add event listener for Following button
         document.getElementById('followingButton').addEventListener('click', function() {
            showSection('2');
         });

         // Function to toggle section visibility
         function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.main_sidebar').forEach(function(section) {
               section.style.display = 'none';
            });

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
         }
      });
   </script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <script>
      function sendFriendRequest(followingname) {
         var url = 'accpted_friend.php'; // Assuming this file is friend.php

         $.ajax({
            type: 'POST',
            url: url,
            data: {
               fing: followingname,
               fer: '<?php echo $_SESSION['username']; ?>'
            },
            success: function(response) {
               if (response.success) {
                  alert('Error sending connection request.');
               } else {
                  alert('Connection request sent successfully.');
               }
            },
            error: function() {
               alert('Follow successfully.');
               location.reload();
            }
         });
      }

      function removeFriendRequest(followingname) {
         var url = 'accpted_friend.php'; // Assuming this file is friend.php

         $.ajax({
            type: 'POST',
            url: url,
            data: {
               following: followingname,
               follower: '<?php echo $_SESSION['username']; ?>'
            },
            success: function(response) {
               if (response.success) {
                  alert('Unfollow successfull');
                  location.reload();
               } else {
                  alert('Connection request sent successfully.');
               }
            },
            error: function() {
               alert('Unfollow successfull');
               location.reload();
               
            }
         });
         
      }

   </script>

</body>

</html>