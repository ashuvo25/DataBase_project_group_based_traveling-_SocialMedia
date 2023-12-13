<?php
include('server.php');
//require(__DIR__.'/../login.php');
include(__DIR__ . "/../Web_Design/DBconnection.php");
$_SESSION['reciver'] = $_SESSION['username'];


if (!isset($_SESSION['username'])) {
   header('Location: home.php');
   $_SESSION['reciveer'] = $_SESSION['username'];
   exit();
}
$username = $_SESSION['username'];
$_SESSION['groupID']=" ";
$_SESSION['view_group']="";
// echo  $username;
$link = select_profile_edit($username);
?>
<!DOCTYPE html>
<html>

<head>
   <meta charset='UTF-8'>
   <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <title> ForestMeN </title>
   <link rel="stylesheet" href="/Home_pages/CSS_home/home.css">
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
            <li class="nav_list"> <a href="#"  ><img src="/Home_pages/image/icons/homes.png" class="nav_icon"><span class="span_text">Home</span></a></li>
            <li class="nav_list" id="connectButton"> <a href="/Home_pages/Pagess/Friends/accpted_friend.php" id="connectButton"><img src="/Home_pages/image/icons/networking.png" class="nav_icon"><span class="span_text">Network</span></a></li>
            <li class="nav_list"> <a href="/Web_Design/view_group/Group-page-design/index.php"><img src="/Home_pages/image/icons/group.png" class="nav_icon"><span class="span_text">Groups</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/deal.png" class="nav_icon"><span class="span_text">Sponsor</span></a></li>
            <li class="nav_list"> <a href="/Home_pages/Pagess/verification/veified.php"><img src="/Home_pages/image/icons/verified.png" class="nav_icon"><span class="span_text">Verification</span></a></li>
            <li class="nav_list"> <a href="/Web_Design/Chat_Box/index.php"><img src="/Home_pages/image/icons/comments.png" class="nav_icon"><span class="span_text">Message</span></a></li>
         </ul>
      </div>
      <div class="nav_right">
         <!-- login_signup_page\Web_Design\Profile_Edit\Home_index.php -->
         <?php
         $name = $link['name'];
         ?>

         <!-- Home_pages\CSS_home\Pagess\verification -->
         <?php if ($link['verified'] == "YES") { ?>
            <div class="profile">
               <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
                  <img src="<?php echo isset($link['image']) ? 'uploads/' . $link['image'] : 'path/to/default/image.jpg'; ?>" alt="" height="40px" width="50px" class="img_prof">
                  <p><?php echo $name; ?></p>
               </a>
            </div>
         <?php } else { ?>
            <div class="profile_1">
               <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
                  <img src="<?php echo isset($link['image']) ? 'uploads/' . $link['image'] : 'path/to/default/image.jpg'; ?>" alt="" height="40px" width="50px" class="img_prof">
                  <p><?php echo $name; ?></p>
               </a>
            </div>
         <?php } ?>

      </div>
   </nav>

   <!-- #region div.container----------------------------------------------------------->

   <div class="container">
      <!-- left side------------------------ ---------------------------------------->
      <div class="left_sidebar">

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


      <!------------------------------------------- middle side----------------------------------------------------------------- -->
      <div class="main_sidebar">
         <!-- cintent posting ----------------------->
         <?php
         if (!empty($statusMsg)) {  ?>

            <p class="alart alart-<?php echo $status; ?>"><?php echo $statusMsg ?></p>

         <?php } ?>

         <!-- -----------post edit----------------------->


         <?php

         ?>

         <?php

         $statusMsg = '';
         // fille directory
         $teergatDie = 'uploads/';
         if (isset($_POST['submit'])) {

            $file = '';
            $discrip = $_POST['description'];
            $location = $_POST['location'];
            $private = isset($_POST['private']) ? 1 : 0;
            if (!empty($_FILES["image"]["name"])) {
               $file_name = basename($_FILES["image"]["name"]);
               $file_Path = 'uploads/' . $file_name;
               $file_type =  pathinfo($file_Path, PATHINFO_EXTENSION);
               $file_name1 = basename($_FILES["image1"]["name"]);
               $file_Path1 = 'uploads/' . $file_name1;
               $file_type1 =  pathinfo($file_Path1, PATHINFO_EXTENSION);



               $allow = array('jpg', 'jpge', 'png');
               //uplode file to server
               if (in_array($file_type, $allow)) {
                  if (
                     move_uploaded_file($_FILES['image']['tmp_name'], $file_Path) ||
                     move_uploaded_file($_FILES['image1']['tmp_name'], $file_Path1)
                  ) {
                     // insert file into data base
                     $stmt = $conn->prepare("INSERT INTO post_table (file_name, date_time, text_content, user_name_post_table, locations, privacy, file_name1) VALUES (?, NOW(), ?, ?, ?, ?, ?)");
                     $stmt->bind_param("ssssss", $file_name, $discrip, $username, $location, $private, $file_name1);
                     $stmt->execute();
                     $stmt->close();


                     header("location:home.php");
                  }
               }
               $conn->close();
            }
         }
         ?>

         <div class="story_post">
            <div class="story_content">

               <form action="home.php" method="post" enctype="multipart/form-data" class="post_form">
                  <label for="form" class="img_level"><br>Post your day: </label>
                  <textarea rows="5" cols="60" name="description" placeholder="Write Something" class="input_text"></textarea>
                  <label for="image" class="img_level"><br>Location &nbsp&nbsp &nbsp&nbsp : </label>
                  <input type="text" name="location" class="location_text" placeholder="Location">
                  <label for="private" class="img_level">&nbsp&nbsp &nbsp&nbsp Private:</label>
                  <input type="checkbox" name="private" id="private">
                  <label for="image" class="img_level"><br>Images &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp: </label>
                  <input type="file" name="image" id="image_post" placeholder="Write something" class="imageinp" required>
                  <input type="file" name="image1" id="image_post" placeholder="Write something" class="imageinp" required>

                  <!-- <input type="file" name="image3" id="image_post" placeholder="Write something" class="imageinp"> -->
                  <input type="submit" name="submit" class="btn" value="Post" required>
               </form>
            </div>

         </div>

         <!----------------   -- Post story one time--------------------------------------------------------------->

         <div class="story_one_time">





         </div>


         <!------------------------------- post write ------------------------------>

         <?php

         $user_id = 1;
         // queary for featch data.

         $sql = "SELECT * FROM post_table ORDER BY date_time DESC";


         $posts = mysqli_query($conn, $sql);

         foreach ($posts as $post) : /////////////////////////////////for each 
            $post_id = $post["id"];
            $likesCount = mysqli_fetch_assoc(
               mysqli_query(
                  $conn,
                  "SELECT COUNT(*) AS likes FROM rating_info WHERE post_id  = $post_id AND status = 'like'"
               )
            )['likes'];

            $dislikesCount = mysqli_fetch_assoc(mysqli_query(
               $conn,
               "SELECT COUNT(*)AS dislikes FROM rating_info WHERE post_id  = $post_id AND status = 'dislike'"
            ))['dislikes'];

            $status = mysqli_query($conn, "SELECT status FROM rating_info WHERE post_id = $post_id AND user_id = $user_id");

            if (mysqli_num_rows($status) > 0) {
               $status = mysqli_fetch_assoc($status)['status'];
            } else {
               $status = 0;
            }


            /// ----profile image set-----------------          

         ?>
            <div class="post_wrapper">



            </div>
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

                           <img src="<?php echo $imguel11; ?>" alt="" height="50px" width="50px" class="img_prof">

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

               <?php echo $post['text_content'];
               echo "<br>";
               $post_id = $post["id"];
               // ...
               if ($posts->num_rows > 0) {
                  $row = $post;
                  $imguel = 'uploads/' . $row['file_name'];
                  $imguel1 = 'uploads/' . $row['file_name1'];
               ?>
                  <?php
                  // Create an array of image URLs
                  $imageURLs = array($imguel, $imguel1);

                  foreach ($imageURLs as $imageURL) {
                     if (!empty($imageURL)) {
                        echo '<img src="' . $imageURL . '" alt="" height="300px" width="200px" class="img_posts">';
                     }
                  }
                  ?>
               <?php
               }
               ?>
               <div class="post_info">
                  <button class="like" <?php if ($status == 'like') echo "selected"; ?> data-post-id=<?php echo $post_id; ?>>
                     <i class="fa fa-star fa-lg"></i>
                     <span class="likes_count <?php echo $post_id; ?>" data-count=<?php echo $likesCount; ?>> <?php echo $likesCount; ?></span>

                  </button>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
      <!----------------------------- right side----------------------------------------------------------------- -->
      <div class="right_sidebar">
         <div class="imp-links">

            <a href=""><img src="/Home_pages/image/icons/newspaper.png" class="friend">&nbsp Latest Update</a>
            
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




   <!---------------------------------java script------------------------------------------------------------------>
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
   <script type="text/javascript">
      $('.like , .dislike').click(function() {

         var data = {

            post_id: $(this).data('post-id'),
            user_id: <?php echo $user_id ?>,
            status: $(this).hasClass('like') ? 'like' : 'dislike',
         };
         $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success: function(response) {
               var post_id = data['post_id'];
               var likes = $('.likes_count' + post_id);
               var likesCount = likes.data('count');
               var dislikes = $('.dislikes_count' + post_id);
               var dislikesCount = dislikes.data('count');


               var likeButton = $(".like[data-post-id = " + post_id + "]");
               var dislikeButton = $(".dislike[data-post-id = " + post_id + "]");

               if (response === 'newlike') {
                  likes.html(likesCount + 1);
                  likeButton.addClass('selected');
               } else if (response === 'newdislike') {
                  dislikes.html(dislikesCount + 1);
                  dislikeButton.addClass('selected');
               } else if (response === 'changetolike') {
                  likes.html(parseInt($('.likes_count' + post_id).text()) + 1);
                  dislikes.html(parseInt($('.dislikes_count' + post_id).text()) - 1);
                  likeButton.addClass('selected');
                  dislikeButton.removeClass('selected');
               } else if (response === 'changetodislike') {
                  likes.html(parseInt($('.likes_count' + post_id).text()) - 1);
                  dislikes.html(parseInt($('.dislikes_count' + post_id).text()) + 1);
                  likeButton.removeClass('selected');
                  dislikeButton.addClass('selected');
               } else if (response ==='deletelike') {
                  likes.html(parseInt($('.likes_count' + post_id).text()) - 1);
                  likeButton.removeClass('selected');
               } else if (response === 'deletedislike') {
                  likes.html(parseInt($('.dislikes_count' + post_id).text()) - 1);
                  dislikeButton.removeClass('selected');
               }
            }

         })
      })


      document.addEventListener('DOMContentLoaded', function () {
    const connectButton = document.getElementById('connectButton');
    const userListContainer = document.getElementById('search-result');

    connectButton.addEventListener('click', function () {
       
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                   
                    userListContainer.innerHTML = xhr.responseText;
                } else {
                    console.error('Error fetching users:', xhr.status);
                }
            }
        };

        xhr.open('GET', 'Home_pages/Pagess/Friends/friends.php');
        xhr.send();
    });
});


   </script>
</body>

</html>