<?php 

include(__DIR__.'/../../../Web_Design/DBconnection.php');

session_start();

if (!isset($_SESSION['username'])) {
   header('Location: friends.php');
   exit();
}
$username = $_SESSION['username'];
$link = select_profile_edit($username);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <meta name= 'viewport' content='width=device-width, initial-scale=1.0'>
  <title>  </title>
  <link rel="stylesheet" href="friends.css">
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
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/homes.png" class="nav_icon"><span class="span_text">Home</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/networking.png" class="nav_icon"><span class="span_text">Network</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/group.png" class="nav_icon"><span class="span_text">Groups</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/deal.png" class="nav_icon"><span class="span_text">Sponsor</span></a></li>
            <li class="nav_list"> <a href="/Home_pages/Pagess/verification/veified.php"><img src="/Home_pages/image/icons/verified.png" class="nav_icon"><span class="span_text">Verification</span></a></li>
            <li class="nav_list"> <a href="#"><img src="/Home_pages/image/icons/comments.png" class="nav_icon"><span class="span_text">Message</span></a></li>
         </ul>
      </div>
      <div class="nav_right">
         <!-- login_signup_page\Web_Design\Profile_Edit\Home_index.php -->
         <?php
         $link = select_profile_edit($username);
         $name = $link['name'];
         ?>
         <!-- Home_pages\CSS_home\Pagess\verification -->
          <!-- Home_pages\uploads -->
         <div class="profile">
            <a href="/Web_Design/Profile_Edit/Home_index.php" class="profile-link">
               <img src="<?php echo 'Home_pages/uploads/' . $link['image']; ?>" alt="" height="40px" width="40px" class="img_prof">
               <p><?php echo $name; ?></p>
            </a>
         </div>
      </div>
   </nav>

</body>
</html>