<?php

include(__DIR__ . "/../DBconnection.php");
session_start();

if (!isset($_SESSION['username'])) {
  http_response_code(401); // Unauthorized
  exit("Unauthorized access");
}

$username = $_SESSION['username'];
echo $username;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["fileImg"])) {
  $targetDirectory = $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/Home_pages/uploads/';
  $imageName = uniqid() . $_FILES["fileImg"]["name"];
  $targetPath = $targetDirectory . $imageName;

  if (move_uploaded_file($_FILES["fileImg"]["tmp_name"], $targetPath)) {
    $query = "UPDATE signups SET prof_text = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $imageName, $username);
    header("Location:Home_index.php");
    if ($stmt->execute()) {
      echo "Image updated successfully";
      exit();
    } else {
      http_response_code(500); 
      echo "Error updating image in the database: " . $stmt->error;
    }
  } else {
    http_response_code(500); // Internal Server Error
    echo "Error moving uploaded file";
  }
} else {
  http_response_code(400); // Bad Request
  echo "Invalid request";
}

?>
