<?php

include_once "../database/userUtils.php";
include_once "../services/checkIfUserExistsService.php";
include_once "../constants/newsConstants.php";

if (isset($_GET["userID"])) {
    $userID = $_GET["userID"];
} else {
    $userID = null;
}

if ($userID === null or !checkIfUserExists($userID)) {
    redirectToNewsPage();
    return;
}

deleteUserFromNewsfilter($userID);
redirectToNewsPage(UNSUBSCRIBED);
return;


function redirectToNewsPage($status = null) {
    if ($status === null) {
        header("location: ../templates/newsPage.php");
    } else {
        header("location: ../templates/newsPage.php?status=" . $status);
    }
    return;
}