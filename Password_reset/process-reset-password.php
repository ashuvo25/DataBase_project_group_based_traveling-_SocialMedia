<?php
include("reset_pass.php");

$hostName = 'localhost:3307';
$dbUser = 'root';
$dbPassword = "";
$dbName = "dbms_project";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $passn = $_POST['password'];
    $passr = $_POST['password_confirmation'];
    $username = $_POST['username'];

    if ($passn != $passr) {
        echo "Passwords do not match";
    } elseif (strlen($passn) < 8) {
        echo "Password must be at least 8 characters";
    } else {
        $token_hash = hash("sha256", $passn);

        // Check if the token already exists
        $checkSql = "SELECT COUNT(*) FROM signups WHERE reset_token_hash = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $token_hash);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        $query = "SELECT * FROM signups WHERE username = ?";
        $queryStmt = $conn->prepare($query);
        $queryStmt->bind_param("s", $username);
        $queryStmt->execute();
        $queryResult = $queryStmt->get_result();

        if ($checkResult->fetch_row()[0] > 0) {
            echo "Token already used";
        } elseif ($queryResult->num_rows === 0) {
            echo "Username not found"; // Check if the username exists
        } else {
            $updateSql = "UPDATE signups SET passwords=?, reset_token_hash=NULL, reset_token_expire=NULL WHERE username = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $passn, $username);

            if ($updateStmt->execute()) {
                header("Location: welcome.php");
                exit();
            } else {
                echo "Error: " . $updateStmt->error;
            }
        }
    }
}
?>
