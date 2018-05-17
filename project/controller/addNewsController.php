<?php

include_once "../constants/newsConstants.php";
include_once "../constants/globallyUsedConstants.php";
include_once "../database/newsUtils.php";
include_once "../utils/sessionUtils.php";

loginRequired(ADMIN_ROLE);


$header = getDataFromPOST("header");
$content = getDataFromPOST("content");

if ($header === null or $content === null) {
    redirectToAddNewsPageWithMessage(NOT_ENOUGH_DATA);
    return;
}

$result = saveNews($header, $content);

if (!$result) {
    redirectToAddNewsPageWithMessage(NEWS_SAVING_FAILED);
} else {
    redirectToAddNewsPageWithMessage(NEWS_SUCCESSFULLY_SAVED);

}

function getDataFromPOST($key) {
    if (isset($_POST[$key]) and $_POST[$key] !== "") {
        return $_POST[$key];
    } else {
        return null;
    }
}

function redirectToAddNewsPageWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/addNewsPage.php?status=' . $status);
}