<?php
    $title = "Main Page";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Log in</h1>
    <form action="auth_check.php" method="post">
        <label>E-mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" value="Log in">
    </form>
    <br>
    <a href="reg/registration.php">Don't have an account?</a>
</body>
</html>
