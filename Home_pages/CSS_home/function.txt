<?php 

require 'server.php';

$post_id = $_POST["post_id"];
$user_id = $_POST["user_id"];
$status = $_POST["status"];

$ratings = mysqli_query($conn, "SELECT * FROM rating_info WHERE post_id = $post_id AND user_id = $user_id");

if(mysqli_num_rows($ratings) > 0){
    $ratings = mysqli_fetch_assoc($ratings);

    if($ratings['status'] == $status){
        mysqli_query($conn, "DELETE FROM rating_info WHERE post_id = $post_id AND user_id = $user_id");
        echo "delete" . $status;
    }
    else{
        mysqli_query($conn, "UPDATE rating_info SET status = '$status' WHERE post_id = $post_id AND user_id = $user_id");
        echo "change to " . $status;
    }
}
else{
    mysqli_query($conn, "INSERT INTO rating_info VALUES('', '$post_id', '$user_id', '$status')");
    echo "new" . $status;
}
?>
