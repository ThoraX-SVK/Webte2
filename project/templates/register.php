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
    echo $errorMessage;
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

        if ($status == ERROR_PASSWORD_MISMATCH) {
            return "<h3 class='register-status-message'>Heslá sa nezhodujú</h3>";
        } else if ($status == ERROR_EMAIL_TAKEN) {
            return "<h3 class='register-status-message'>Email je už používaný</h3>";
        } else if ($status == ERROR_EMAIL_INVALID) {
            return "<h3 class='register-status-message'>Email nie je v platnom formáte</h3>";
        } else if ($status == ERROR_SAVING_FAIL) {
            return "<h3 class='register-status-message'>Chyba pri ukladaní</h3>";
        } else if ($status == INVALID_POST) {
            return "<h3 class='register-status-message'>Nevyplnené registračné údaje</h3>";
        }
    }

    return null;
}

?>

</body>
</html>