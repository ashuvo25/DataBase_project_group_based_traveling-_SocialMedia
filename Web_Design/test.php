<!------------------------------------------- middle side----------------------------------------------------------------- -->
<div class="main_sidebar">
 <!-- cintent posting ----------------------->
         <?php 
         if(!empty($statusMsg)){  ?>

            <p class="alart alart-<?php echo $status;?>"><?php echo $statusMsg ?></p>

        <?php } ?>

<!-- -----------post edit----------------------->
                 

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];
?>

<?php   

                   $statusMsg = '';
                   // fille directory
                   $teergatDie = 'uploads/';
                   if(isset($_POST['submit'])){
                     
                       $file='';
                      
                
                       if(!empty($_FILES["image"]["name"]) ){
                           $file_name = basename($_FILES["image"]["name"]);
                           $file_Path = 'uploads/'.$file_name;
                           $file_type =  pathinfo($file_Path,PATHINFO_EXTENSION);
                           $allow = array('jpg','jpge','png');
                   //uplode file to server
                           if(in_array($file_type,$allow)){
                               if (move_uploaded_file($_FILES['image']['tmp_name'], $file_Path)  ){
                               // insert file into data base
                               $insert = $conn ->query("INSERT INTO post_table (file_name,date_time,text_content,user_name_post_table,locations,privacy)
                               VALUES ('".$file_name. "',NOW(),'$discrip','$username','$location','$private');
                               ");
                             
                               header("location:home.php");
                           }}
                        $conn->close();
                        }}
                   ?>

            <div class="story_post">
               <div class="story_content">
                
               <form action="home.php" method="post" enctype="multipart/form-data" class="post_form" >
               <label for="form" class="img_level" ><br>Post your day: </label>
                  <textarea rows = "5" cols = "60" name = "description" placeholder="Write Something" class="input_text" ></textarea>
                  <label for="image" class="img_level" ><br>Location &nbsp&nbsp &nbsp&nbsp    : </label>
                  <input type="text" name="location" class="location_text"  placeholder="Location">
                  <label for="private" class="img_level">Private/public:</label>
                   <input type="checkbox" name="private" id="private" >
                  <label for="image" class="img_level" ><br>Select Image: </label>
                   <input type="file" name="image" id="image_post" placeholder="Write something"  class="imageinp">
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


             $posts=mysqli_query($conn, $sql);

              foreach($posts as $post)://///////////////////////////////for each 
               $post_id = $post["id"];
               $likesCount = mysqli_fetch_assoc(mysqli_query($conn,
               "SELECT COUNT(*) AS likes FROM rating_info WHERE post_id  = $post_id AND status = 'like'")
           )['likes'];
           
            $dislikesCount = mysqli_fetch_assoc(mysqli_query($conn,
            "SELECT COUNT(*)AS dislikes FROM rating_info WHERE post_id  = $post_id AND status = 'dislike'"))['dislikes'];
            
            $status = mysqli_query($conn,"SELECT status FROM rating_info WHERE post_id = $post_id AND user_id = $user_id");

            if(mysqli_num_rows($status) > 0){
               $status = mysqli_fetch_assoc($status)['status'];
            }
            else{
               $status = 0;
            }

            
           /// ----profile image set-----------------          
                 
            ?>
                <div class="post_wrapper">
             
   
                  <div class="post">
                 <div class="prof">
                 <div class="user_name">
      <!-- Small Profile section ------------------------ -->
                 <?php
$post_id = $post["id"];
$immg = "SELECT prof_text FROM signups WHERE username = ?";
$stmt = $conn->prepare($immg);
$stmt->bind_param("s", $username); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imguel = 'uploads/' . $row['prof_text'];
    ?>
    <img src="<?php echo $imguel; ?>" alt="" height="50px" width="50px" class="img_prof">
    <?php
}
?>
        
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

                  <?php  echo $post['text_content'] ; 
                    echo "<br>";                    
                    $post_id = $post["id"];
                    // ...
                    if ($posts->num_rows > 0) {
                        $row = $post;
                        $imguel = 'uploads/' . $row['file_name'];
                        ?>
                        <img src="<?php echo $imguel; ?>" alt="" height="250px" width="250px" class="img_posts">
                        <?php
                    }
                    
                ?>
  
                  
              
                     <div class="post_info">
                       <button  class="like" <?php if($status == 'like') echo "selected"; ?> data-post-id = <?php echo $post_id; ?> >
                       <i class="fa fa-thumbs-up fa-lg"></i>
                       <span class="likes_count <?php echo $post_id; ?>" data-count = <?php  echo $likesCount;?> > <?php  echo $likesCount;?></span>
                   
                     </button>

                       <button class="dislike" <?php if($status == 'dislike') echo "selected"; ?> data-post-id = <?php echo $post_id; ?> >
                       <i class="fa fa-thumbs-down fa-lg"></i>
                       <span class="dislikes_count <?php echo $post_id; ?>" data-count = <?php  echo $dislikesCount;?> > <?php  echo $dislikesCount;?></span>
                    
                     </button>
                     </div>
                  </div>                
                </div>
                <?php endforeach ?>
        </div>