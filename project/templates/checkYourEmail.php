<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Registration successful</title>
</head>
<body>

<div class="main">
    <div class="success-message">
        Registration successful
    </div>

    <p class="align-middle">
        <?php
        echo getPageContents();
        ?>
    </p>



</div>

</body>
</html>


<?php

function getEmail() {
    $email = "";

    if (isset($_GET["email"])) {
        $email = $_GET["email"];
    }

    return $email;
}

function enableEmailSplit($email){
    $split =(explode("@",$email));
    $email = $split[0] ."@<wbr>". $split[1];
    return $email;
}

function getPageContents() {
    $email = getEmail();
    $email = enableEmailSplit($email);
    return "Please check your email <br> <em>$email </em><br> to complete the activation process of your account";
}

?>
