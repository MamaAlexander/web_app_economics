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
    <form action="index.php" method="post">
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

<?php
    $email = $_POST["email"];
    $password = $_POST["password"];
    $flag = 0;
    if(strlen($password) < 8){
        echo "<br>" . "Password is not valid";
        $flag++;
    } 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<br>" . "E-mail is not valid";
        $flag++;
    }
    if($flag > 0){
        echo "<br>" . "Try again!";
    }
?>