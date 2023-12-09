

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Reset Password</h1>
    <form method="post" action="process-reset-password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <label for="password">New password</label>
        <input type="password" id="password" name="password" required>
        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <button>Send</button>
    </form>
</body>
</html>
