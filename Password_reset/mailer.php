<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;

 require __DIR__ . '/vendor/autoload.php';


 $mail = new PHPMailer(true);

 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

 $mail -> isSMTP();
 $mail ->SMTPAuth = true;

 $mail->Host       = 'smtp.gmail.com';  
 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                   // GMAIL SMTP server address

 $mail->Port       = 587;
 $mail ->Username = "forwebsitesheet@gmail.com";
 $mail ->Password = "fvyolbqallbvkust";

 $mail ->isHTML(true);
 
 return $mail;

?>