
<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <meta name= 'viewport' content='width=device-width, initial-scale=1.0'>
  <title> Reset Password </title>
  <link rel="stylesheet" href="css/reset.css">
</head>
<body>


    <div class="container">

        <div class="box form-box">
        <?php
         //php code start_________________________--------------------->>>
         $hostName ='localhost:3307';
         $dbUser = 'root';
         $dbpassword="";
         $dbName = "dbms_project";
         $conn = mysqli_connect($hostName ,$dbUser ,$dbpassword,$dbName);
         if(!$conn){
           die("Somthing went wrong");
        }

         if(!$conn){
            die("Connection failed");
           }
           else{
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                $email=$_POST['email'];

                $token = bin2hex(random_bytes(16));
                $token_hash = hash("sha256" ,$token);

                $expire = date("Y-m-d H:i:s", time() + 60*30) ;
                $sql = "UPDATE signups 
                        SET reset_token_hash = ?,
                            reset_token_expire = ? 
                            WHERE email = ?";
                $stmt = $conn ->prepare($sql);
                $stmt ->bind_param('sss', $token_hash , $expire , $email );
                $stmt ->execute();
                
                if($conn ->affected_rows){

                    $mail = require __DIR__ ."/mailer.php";
                    $mail->setFrom("forwebsitesheet@gmail.com");
                    $mail ->addAddress($email);
                    $mail ->Subject ="Reset password link";
                    $mail ->Body = <<<END

                    Click <a href = "http://localhost:3000/login_signup_page/Password_reset/reset_pass.php?token=$token">here </a>
                    to reset your password.
                    
                    END;
                    try{
                        $mail->send();
                    }catch(Exception $e){
                        echo"Message could not send .Mailer error:{$mail->ErrorInfo}";
                    }

                }

                if ($stmt->execute()) {
                    echo "<div class='message' style='color: green;'>
                    <p>Email send successfully !</p> </div> <br>";
                    echo"<a href='/login_signup_page/login.php'> <button class = 'btn'> Login Now </button></a>";
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            
                $stmt->close();
                $conn->close();

            }
        }

         // php code end ---------------------------------------------->>>
   ?>

            <header>Reset Password</header>
            <form action="reset.php" method="post">
               
                 <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                 </div>

                 <div class="field">
                
                    <input type="submit" name="submit" class="btn" value="Reset" required>
                 </div>

                 <div class="links">
                    <br>Already have an account ? <a href="/login_signup_page/login.php">Login</a>

                    
                 </div>

            </form>
        </div>

    </div> 
      
</body>
</html>