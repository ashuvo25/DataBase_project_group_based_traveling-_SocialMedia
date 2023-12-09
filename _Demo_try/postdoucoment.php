


<?php  


$hostName ='localhost:3307';
$dbUser = 'root';
$dbpassword="";
$dbName = "dbms_project";
$conn = mysqli_connect($hostName ,$dbUser ,$dbpassword,$dbName);
 if(!$conn){
    die("Somthing went wrong");
 }
$statusMsg = '';
$status = 'denger';
// fille directory
$teergatDie = 'uploads/';
if(isset($_POST['submit'])){
    $file='';
    $discrip = $_POST['description'];
    if(!empty($_FILES["image"]["name"]) or !empty($_POST['description'])){
        $file_name = basename($_FILES["image"]["name"]);
        $file_Path = 'uploads/'.$file_name;
        $file_type =  pathinfo($file_Path,PATHINFO_EXTENSION);
        $allow = array('jpg','jpge','png');
//uplode file to server
        if(in_array($file_type,$allow)){
            if (move_uploaded_file($_FILES['image']['tmp_name'], $file_Path)){
            // insert file into data base
            $insert = $conn ->query("INSERT INTO post_table (file_name,date_time,text_content)
            VALUES ('".$file_name. "',NOW(),'$discrip');
            ");
            header("Loaction:home.php");
            if($insert){ $status = "Post SuccessFull !";
            } 
           }
        }
    }
}
?>