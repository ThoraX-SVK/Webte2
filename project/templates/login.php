<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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

<form method="POST" action="../controller/loginController.php">

    <input type="email" id="email" name="email" placeholder="Email" required
        <?php
        if (isset($_GET["email"])) {
            echo 'value="' . $_GET["email"] . '"';
        }
        ?>
    >
    <input type="password" id="password" name="password" placeholder="Heslo" required>
    <input type="submit" value="Prihlásiť sa">

</form>

<!--<a href=" passwordResetPage.php "> Zabudol som heslo </a>-->

</body>
</html>




