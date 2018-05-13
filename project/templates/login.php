<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<?php

if (isset($_GET["status"])) {

    $status = $_GET["status"];
    if ($status == "INVALID") {
        echo "<h3 class='login-status-message'> Neplatné prihlasovacie údaje</h3>";
    }
}
?>

<body>
<div class="main">
    <form action="../controller/loginController.php" method="post" class="login">
        <span> Email </span>
        <br><input type="text" placeholder="Email" name="email" required
            <?php
            if (isset($_GET["email"])) {
                echo 'value="' . $_GET["email"] . '"';
            }
            ?>
        >
        <br><br><span> Password </span>
        <br><input type="password" placeholder="Password" name="password" required>
        <br><br><input type="submit" value="Login">

    </form>

    <form action="register.php" class="bottom-left">
        <button type="submit" class="bottom-left-button"><span style="color:white; font-size: 40px;"> +</span> New Account</button>
    </form>

    <form action="passwordResetPage.php" class="bottom-right">
        <button type="submit" class="bottom-right-button">Need help<span style="color:white; font-size: 40px;">?</span></button>
    </form>



</div>

</body>
</html>




