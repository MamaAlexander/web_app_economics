<?php

setcookie("token", "", time() - 3600*24,  "/", "", true, true);

header('location:index.php');

?>