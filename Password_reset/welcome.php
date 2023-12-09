
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <style>
        body {
            background: #202b38; 
            color: white; 
        }
        .message {
            color: green;
        }
        h2 {
            color: green;
        }
        a {
            color: blue;
        }
    </style>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <div class='message'>
        <p><h2>Password reset successfully!</h2></p>
    </div>
    <form method="post" action="process-reset-password.php">
        <a href="/login_signup_page/login.php"> Login now! </a>
    </form>
</body>
</html>
