<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php
// ERROR SHOWING
include_once "../constants/registerConstants.php";

$errorMessage = getErrorMessage();
if ($errorMessage != null) {
    echo "<h3 class='register-status-message'>";
    echo $errorMessage;
    echo "</h3>";
}
?>

<form method="POST" action="../controller/singleRegistrationController.php">

    <input type="email" id="email" name="email" placeholder="Email" required>
    <input type="text" id="name" name="name" placeholder="Meno" required>
    <input type="text" id="surname" name="surname" placeholder="Priezvisko" required>
    <input type="password" id="password" name="password" placeholder="Heslo" required>
    <input type="password" id="password-confirm" name="password-confirm" placeholder="Potvrdťe heslo" required>
    <input type="submit" value="Registrovať účet">

</form>

<?php

function getErrorMessage()
{
    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case ERROR_PASSWORD_MISMATCH:
                return "Heslá sa nezhodujú";
            case ERROR_EMAIL_TAKEN:
                return "Email je už používaný";
            case ERROR_EMAIL_INVALID:
                return "Email nie je v platnom formáte";
            case ERROR_SAVING_FAIL:
                return "Chyba pri ukladaní";
            case INVALID_POST:
                return "Nevyplnené registračné údaje";
        }

    }

    return null;
}

?>

</body>
</html>