<?php
session_start();
include(__DIR__ . "/../../../Web_Design/DBconnection.php");

include(__DIR__ . '/../../server.php');
if (isset($_POST['authorizeSubmit'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    // Fetch allowed domains from the database table
    $allowedDomainsQuery = "SELECT domain FROM univ_domain";
    $allowedDomainsResult = mysqli_query($conn, $allowedDomainsQuery);
    if (!$allowedDomainsResult) {
        echo "Error fetching allowed domains from the database";
        exit;
    }
    $allowedDomains = [];
    while ($row = mysqli_fetch_assoc($allowedDomainsResult)) {
        $allowedDomains[] = $row['domain'];
    }
    $emailParts = explode('@bscse.', $email);
    $user = select_profile_edit($_SESSION['username']);
    if (count($emailParts) === 2) {
        $domain = $emailParts[1];

        // Check if the domain is allowed
        if ($user["verified_mail"] == $email) {
            echo '<script>console.log("This email is already verified");</script>';
        }
        if (in_array($domain, $allowedDomains)) {
            $otp = generateOTP();
            sendEmail($email, $otp);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            $_SESSION['showOTPForm'] = true;
            echo '<script>showOTPForm();</script>'; // Add this line to call the JavaScript function
        } else {
            echo "Invalid domain: $domain";
        }

        echo '<script>alert("OTP sent successfully!");</script>';
    } else {
        echo "Invalid email address format";
    }
} elseif (isset($_POST['otpSubmit'])) {
    $enteredOTP = isset($_POST['otp']) ? $_POST['otp'] : '';
    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $enteredOTP) {
        echo 'Thank you for verification!';
        // $Name = ''; 
        $postData = array(
            'verified_mail' => isset($_SESSION['email']) && $_SESSION['email'] !== '' ? $_SESSION['email'] : $Name,
            'verified' => "YES",
        );

        if (!empty($_SESSION['email'])) {

            updateProfile($_SESSION['username'], $postData);
            echo '<script>alert("verified successfully!");</script>';
            header('Location: /Home_pages/home.php');
        }

        exit;
    } else {
        echo 'Incorrect OTP. Please try again.';
    }
}

if (isset($_SESSION['showOTPForm']) && $_SESSION['showOTPForm']) {
    echo '<script>';
    echo 'document.getElementById("authorizeForm").style.display = "none";';
    echo 'document.getElementById("otpForm").style.display = "block";';
    echo '</script>';
    unset($_SESSION['showOTPForm']); // Reset the flag

}
function generateOTP()
{
    return rand(100000, 999999);
}
function checkEmailInDatabase($email)
{
    global $conn;
    $query = "SELECT email FROM signups WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function updateVerifiedStatus($username)
{
    global $conn;
    $updateQuery = "UPDATE signups SET verified = 'yes' WHERE username = '$username'";
    mysqli_query($conn, $updateQuery);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($email, $otp)
{
    require __DIR__ . '/../../../../Password_reset/vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->Username   = "forwebsitesheet@gmail.com";
        $mail->Password   = "fvyolbqallbvkust";

        $mail->setFrom('your@example.com', 'OTP');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'Your OTP is: ' . $otp;
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#003554;
            /*background-image: url(/Img/bggggg.jpg);*/
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #032030  ;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .verification-options {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .verification-options button {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .verification-form {
            display: block;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;

        }

        .verification-form1 {
            align-items: center;
            margin-top: 20px;

        }

        #otp {
            height: 40px;
        }

        .image-inputs {
            display: none;
            margin-top: 20px;
        }

        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .fade-in.active {
            opacity: 1;
        }

        .ing_rotat {
            transform: rotateZ(180deg);
            width: 25px;

        }

        h1 {
            border-bottom: 2px solid green;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1><a href="/Home_pages/home.php"><img src="/Home_pages/image/icons/next.png" alt="" class="ing_rotat"></a>
            &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Verification</h1>

        <div class="verification-options">
            <button onclick="showForm('authorize')">Authorize</button>
            <button onclick="showForm('normal')">Normal</button>
        </div>

        <div id="authorizeForm" class="verification-form">
            <form method="post" action="veified.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit" name="authorizeSubmit">Submit</button>
            </form>

            <div id="otpForm" class="verification-form1" style="display: block;">
                <form method="post" action="veified.php">
                    <label for="otp">OTP:</label>
                    <input type="text" id="otp" name="otp" required>
                    <button type="submit" name="otpSubmit">Submit OTP</button>
                </form>
            </div>

        </div>


        <div id="normalForm" class="image-inputs">
            <label for="image1">Image 1:</label>
            <input type="file" id="image1" name="image1" accept="image/*" required>
            <label for="image2">Image 2:</label>
            <input type="file" id="image2" name="image2" accept="image/*" required>
            <label for="image3">Image 3:</label>
            <input type="file" id="image3" name="image3" accept="image/*" required>
            <button type="submit">Submit</button>
        </div>


    </div>

    <script>
        function showForm(option) {
            if (option === 'authorize') {
                document.getElementById('authorizeForm').style.display = 'block';
                document.getElementById('normalForm').style.display = 'none';

            } else {
                document.getElementById('authorizeForm').style.display = 'none';
                document.getElementById('normalForm').style.display = 'block';
                document.getElementById('otpForm').style.display = 'none';
            }


        }

        function showOTPForm() {
            document.getElementById('authorizeForm').style.display = 'none';
            document.getElementById('otpForm').style.display = 'block';
        }
    </script>

</body>

</html>