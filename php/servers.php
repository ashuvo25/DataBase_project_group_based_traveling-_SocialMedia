<?php
$hostName ='localhost:3307';
$dbUser = 'root';
$dbpassword="";
$dbName = "dbms_project";
$conn = mysqli_connect($hostName ,$dbUser ,$dbpassword,$dbName);
 if(!$conn){
    die("Somthing went wrong");
 }



   ///////////////////////   login function
function login($username,$password){
   global $conn;
   session_start(); 


  //  $_SESSION['username']=$username;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $username = $_POST['username'];
          // $_SESSION['username'] = $username;
          $password = $_POST['password'];
          $query = "SELECT * FROM signups WHERE username = ? AND passwords = ?";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("ss", $username, $password);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $name= $row['username'];
            $email = $row['email'];
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
              header("Location: Home_pages/home.php");
              exit();
          } else {
            echo "<div class='message' style='color: red;'>
            <p> Invalid username or password. Please try again.</p> </div> <br>";
          }
      } 
  }

  ///////////////////////   signup function
function singup($username, $name, $email ,$age , $password ){
 global $conn;
      if(isset($_POST['submit'])){
         $username = $_POST["username"];
         $name = $_POST["name"];
         $email = $_POST["email"];
         $_SESSION["email"]=$email;
         $age = $_POST["age"];
         $password = $_POST["password"];
         $fixedImagePath = "blank-profile-picture-973460_1280.webp";
         // verifing unique email and username
         $verify_query = "SELECT username FROM signups WHERE  username = ?";
         $stmt = $conn->prepare($verify_query);
         $stmt->bind_param("s",$username);

         $stmt->execute();
         $stmt->store_result();
         if ($stmt->num_rows > 0) {
            echo "<div class='message' style='color: red;'>
            <p> Username already taken. Please choose a Different Username.</p> </div> <br>";
           
        }
        else{
         $verify_query = "SELECT email FROM signups WHERE  email = ?";
         $stmt = $conn->prepare($verify_query);
         $stmt->bind_param("s",$email); 

         $stmt->execute();
         $stmt->store_result();
         if ($stmt->num_rows > 0) {
            echo "<div class='message' style='color: red;'>
            <p color 'red'>Email or Username  already taken. Please choose a Different Email or username.</p> </div> <br>"; 
        }
        else{
          if(strlen( $password )<8){
            echo "<div class='message' style='color: red;'>
            <p color 'red'>Password should be 8 charecters.</p> </div> <br>"; 
          }
          else{
            $stmt = $conn->prepare("INSERT INTO signups (username, name, email, age, passwords,prof_text) VALUES (?, ?, ?, ?, ?,?)");

            $stmt->bind_param("ssssss", $username,$name,$email, $age , $password,$fixedImagePath);
            if ($stmt->execute()) {
               echo "<div class='message' style='color: green;'>
               <p>Registration Successfully!</p> </div> <br>";
               echo"<a href='login.php'><button class = 'btn'> Login Now </button></a>";
               exit();
           } else {
               echo "Error: " . $stmt->error;
           }
       
           $stmt->close();
           $conn->close();
           }
          }
         
        
        }
      }
    }






?>


