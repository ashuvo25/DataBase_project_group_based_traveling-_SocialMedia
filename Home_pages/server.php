<?php
$hostName ='localhost:3307';
$dbUser = 'root';
$dbpassword="";
$dbName = "dbms_project";
$conn = mysqli_connect($hostName ,$dbUser ,$dbpassword,$dbName);
 if(!$conn){
    die("Somthing went wrong");
 }

$sql = "SELECT * FROM post_table";
$result=mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result , MYSQLI_ASSOC);






// function insertGroup($title, $from, $to, $start_date, $end_date, $gender, $type_of_journey, $itinerary, $mobile_number,$privacies)
// {
//     global $conn;
//     $sql = "INSERT INTO group ( Title, From, to, Start_date, End_date, Gender, Type_of_journey, Itinerary, Mobile_number,Privacie)
//             VALUES ('$title', '$from', '$to', '$start_date', '$end_date', '$gender', '$type_of_journey', '$itinerary', '$mobile_number','$privacies')";

//     if ($conn->query($sql) === TRUE) {
//         //echo "Successfully inserted data";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

?>