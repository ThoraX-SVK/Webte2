<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <title>Registration</title>
</head>
<body>

<div id="register" class="main">
    <?php
    // ERROR SHOWING
    include_once "../constants/registerConstants.php";

    $errorMessage = getErrorMessage();
    if ($errorMessage != null) {
        echo "<div class='register-status-message'>";
        echo $errorMessage;
        echo "</div>";
    }
    ?>

    <form action="../controller/singleRegistrationController.php" method="POST" id="registerForm" required>
        <br><span> First Name </span>
        <br><input type="text" placeholder="First Name" name="name" required>
        <br><span> Surname</span>
        <br><input type="text" placeholder="Surname" name="surname" required>
        <br><span>E-mail </span>
        <br><input type="text" placeholder="E-mail" name="email" required>
        <br><span> Password </span>
        <br><input type="password" placeholder="Password" name="password" required>
        <br><span> Confirm Password</span>
        <br><input type="password" placeholder="Password" name="password-confirm" required>
        <br><input type="submit" value="Register">
    </form>
</div>


<?php

function getErrorMessage()
{
    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case ERROR_PASSWORD_MISMATCH:
                return "Passwords do not match";
            case ERROR_EMAIL_TAKEN:
                return "Email is already used";
            case ERROR_EMAIL_INVALID:
                return "Email not valid";
            case ERROR_SAVING_FAIL:
                return "Saving failed";
            case INVALID_POST:
                return "Invalid data";
        }

    }

    return null;
}

?>

</body>
</html>