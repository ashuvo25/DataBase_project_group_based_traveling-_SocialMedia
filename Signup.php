<?php
include("php/servers.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <meta name= 'viewport' content='width=device-width, initial-scale=1.0'>
  <title> Sign Up </title>
  <link rel="stylesheet" href="CSS/signup.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <?php
         //php code start_________________________--------------------->>>
          singup('username','name','email','age','password');
         // php code end ---------------------------------------------->>>
         ?>
    <header>Sign Up</header>
            <div class="imgs">
                <img src="/login_signup_page/img/sign-up.png" alt="">
            </div>
            <form action="" method="post">             
                 <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                 </div>
                 <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                 </div>
                 <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"  required>
                 </div>
                 <div class="field input">
                    <label for="age">Age</label>
                    <input type="date" name="age" id="age" required >
                 </div>
                 <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                 </div>
                 <div class="field">              
                    <input type="submit" name="submit" class="btn" value="Sing Up" required>
                 </div>
                 <div class="links">
                    <br>Already have an account ? <a href="login.php">Login</a>                  
                 </div>
            </form>
        </div>
    </div>   
</body>
</html>