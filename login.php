<?php
include("php/servers.php");

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <meta name= 'viewport' content='width=device-width, initial-scale=1.0'>
  <title> Login </title>
  <link rel="stylesheet" href="CSS/loogin.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <?php
         //php code start_________________________--------------------->>>
     
        login('username','password');
         // php code end ---------------------------------------------->>>
         ?>
            <header>Login</header>
            <div class="imgs">
                <img src="/login_signup_page/img/database-storage.png" alt="">
            </div>
            <form action="" method="post">
               
                 <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                 </div>

                 <div class="field input">
                    <label for="password" >Password</label>
                    <input type="password" name="password" id="password" required>
                 </div>

                 <div class="field">
                    
                    <input type="submit" name="submit" class="btn" value="Login" required>
                 </div>

                 <div class="links">
                    <br>Don't have account ? <a href="Signup.php">Sign Up</a>
                    <br><br><a href="/login_signup_page/Password_reset/reset.php">Forgot password?</a>


                 </div>

            </form>
        </div>

    </div> 
      
</body>
</html>