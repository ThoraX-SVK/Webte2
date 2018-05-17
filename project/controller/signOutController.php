<?php

include_once "../utils/sessionUtils.php";

if (isUserLoggedIn()) {
    destroyUserSession();
    session_destroy();
}

header("location: ../templates/login.php");