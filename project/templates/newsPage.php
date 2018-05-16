<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/newsStyle.css">
    <meta charset="UTF-8">
    <title>News Letter</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";

loginRequired();
echo getMenu();

?>

<header>
    <h1>News Letter</h1>
</header>

<div class="content">

    <!--TODO: This is the format of the news message that should be printed with backend-->
    <h2 class="newsHeader"><!--TODO: Here goes header--></h2>
    <hr>
    <p class="newsText"><!--TODO: Here goes content of message--></p>
    <p class="newsDate"><!--TODO: Here goes the date of addition--></p>



</body>
</html>
