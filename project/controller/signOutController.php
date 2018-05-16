<?php

include_once "../utils/sessionUtils.php";

if (isUserLoggedIn()) {
    session_destroy();
}

header("location: ../templates/login.php");