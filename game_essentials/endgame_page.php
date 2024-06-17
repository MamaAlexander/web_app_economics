<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include_once('game_class.php');
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}


$your_country = new Country();
$my_country_won = $your_country->check_winner($_SESSION["count_id"], $_SESSION['op_count_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url(../v904-nunny-012.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh; /* Задаем высоту равной высоте экрана */
        }
    </style>
</head>
<body>
    <?php
    if ($my_country_won) {
        echo '    
        <div class="container">
    	<div class="row">
            <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4 text-center" style="margin-top: 40px">
                    <h1><b>'
                        . $_SESSION["name"] . ', ' .
                    '</b> your country won in game!&#x1F3C6</h1>
                    <div style="margin-top: 40px">
                    <a href="../logout.php"><input type="button" name="button" class="btn btn-light" value="Exit"></a>
                    </div>
                </div>
            </div>
        </div>';
    } else {
        echo '
        <div class="container">
    	<div class="row">
            <div class="col-md-4">&nbsp;</div>
                <div class="col-md-4 text-center" style="margin-top: 40px">
                    <h1><b>'
                        . $_SESSION["name"] . ', ' .
                    '</b> your country lost in game!&#x2639</h1>
                    <div style="margin-top: 40px">
                    <a href="../logout.php"><input type="button" name="button" class="btn btn-light" value="Exit"></a>
                    </div>
                </div>
            </div>
        </div>';
    }
    ?>

</body>
</html>