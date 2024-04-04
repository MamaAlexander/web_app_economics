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
        <input type="text" name="login"><br>
        <label>Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" value="Log in">
    </form>
    <a href="https://youtu.be/PFRGWuMPx4E?si=d-Lvj_InAnyP7l9-">Don't have an account?</a>
</body>
</html>

<?php
    $login = $_POST["login"];
    $password = $_POST["password"];
    $flag = 0;
    if(strlen($password) < 8){
        echo "<br>" . "Password is not valid";
        $flag++;
    } 
    if(!filter_var($login, FILTER_VALIDATE_EMAIL)){
        echo "<br>" . "E-mail is not valid";
        $flag++;
    }
    if($flag > 0){
        echo "<br>" . "Try again!";
    }
?>