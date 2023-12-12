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
$univ = "SELECT * FROM univ_domain";
$univ = [];

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
            <li class="nav_list"> <a href="/Home_pages/Pagess/Friends/friends.php"><img src="/Home_pages/image/icons/networking.png" class="nav_icon"><span class="span_text">Network</span></a></li>
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
             <header class="req" >Requests</header>
             <div class="requests">
   
</div>
         </div>
      </div>

      <div class="main_sidebar">
       
        
        
      </div>

      <!-- -----------------------------------Right Side------------------------------------------- -->
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
    function sendFriendRequest(receiverId) {
        // Use AJAX to send friend request to the server
        $.ajax({
            url: 'friends.php', // Replace with the actual filename
            type: 'POST',
            data: { action: 'sendFriendRequest', receiverId: receiverId },
            success: function (response) {
                // Display a notification to the sender
                if (response.success) {
                    swal("Friend Request Sent!", "Your friend request has been sent.", "success");
                } else {
                    swal("Error", "Something went wrong. Please try again.", "error");
                }
            }
        });
    }

    function handleFriendRequest(action, requestId) {
        // Use AJAX to send accept/reject action to the server
        $.ajax({
            url: 'friends.php', // Replace with the actual filename
            type: 'POST',
            data: { action: action, requestId: requestId },
            success: function (response) {
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
</body>

</html>