<?php
    $title = "Main Page";
?>
<!-- css style -->
<style type="text/css" media="all">
@import url("index.css");
</style>
<!--  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!--  -->
<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
  <circle cx="40" cy="40" r="40" fill="white" />
  <circle cx="40" cy="25.1163" r="14.6977" fill="#DADADA" />
  <mask id="mask0_1_19" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="80" height="80">
    <circle cx="40" cy="40" r="40" fill="#D9D9D9" />
  </mask>
  <g mask="url(#mask0_1_19)">
    <circle cx="40" cy="68.6512" r="26.2326" fill="#DADADA" />
  </g>
</svg>
<!--  -->

    <h1>Log in</h1>
    <form action="auth_check.php" method="post">
        <label>E-mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>
        <button type="submit"><b>Log in</b></button>
    </form>
    <br>
    <a href="reg/registration.php">Don't have an account?</a>
</body>
</html>
