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
    <form action="connect.php" method="POST">
        <label>Name:</label><br>
        <input type="name" name="name" id="name" required><br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" id="email" required><br>
        <!-- <?php 
        // $email = $_POST["email"];
        // if(!filter_var($login, FILTER_VALIDATE_EMAIL)){
        //     header('Location: '.$_SERVER['REQUEST_URI']);
        //     echo "E-mail is not valid" . "<br>";
        // }
        ?> -->
        <br>

        <label>Password:</label><br>
        <input type="text" name="password" id="password" required><br>
        <!-- <?php 
        // $password = $_POST["password"];
        // if(strlen($password) < 8){
        //     header('Location: '.$_SERVER['REQUEST_URI']);
        //     echo "Password is not valid" . "<br>";
        // }
        ?> -->
        <br>

        <label>Password again:</label><br>
        <input type="text" name="password2" id="password2" required><br>
        <!-- <?php 
        // $password = $_POST["password"];
        // $password2 = $_POST["password2"];
        // if($password != $password2){
        //     header('Location: '.$_SERVER['REQUEST_URI']);
        //     echo "Passwords doesn't match" . "<br>";
        // }
        ?> -->
        <br>
        
        <input type="submit" value="Sign in">
    </form>
    <br>
</body>
</html>
