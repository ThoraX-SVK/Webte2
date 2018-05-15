<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>



<body>
<div class="main">
    <?php
    $errorMessage = getErrorMessage();
    if ($errorMessage != null) {
        echo "<div class='login-status-message error-message'>";
        echo $errorMessage;
        echo "</div>";
    }
    ?>
    <!--<div class='login-status-message error-message'> Incorrect Email or Password </div>--> <!--for testing purposes-->
    <form action="../controller/loginController.php" method="post" class="login">
        <span> Email </span>
        <br><input type="text" placeholder="Email" name="email" required
            <?php
            $email = getEmail();
            if ($email != null) {
                echo $email;
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

<?php

function getErrorMessage() {
    include_once '../constants/loginConstants.php';

    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case INVALID_LOGIN:
                return "Incorrect Email or Password";
            case ACCOUNT_INVACTIVE:
                return "Account has not yet been activated";
            case LOGIN_REQUIRED:
                return "Please log in before proceeding";
            case ADMIN_REQUIRED:
                return "Please log in as ADMIN before proceeding";
        }

    }

    return null;
}

function getEmail() {
    if (isset($_GET["email"])) {
        return 'value="' . $_GET["email"] . '"';
    } else {
        return null;
    }
}

?>



