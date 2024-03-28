<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <label>price:</label><br>
        <input type="text" name="price"><br>
        <label>quantitiy:</label><br>
        <input type="text" name="quantitiy"><br>
        <input type="submit" value="total">
    </form>
</body>
</html>

<?php
    $price = $_POST["price"];
    $quantitiy = $_POST["quantitiy"];
    $q = $_POST["price"] * $_POST["quantitiy"];
    echo "total: {$price} * {$quantitiy} = {$q}";
?>