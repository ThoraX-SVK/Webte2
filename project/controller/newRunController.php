<?php

include_once "../utils/sessionUtils.php";
include_once "../database/userUtils.php";
include_once "../database/runUtils.php";
include_once "../constants/loginConstants.php";
include_once "../constants/messageConstants.php";

// check if user logged in, redirect to login if false
loginRequired();

$distanceTraveled = getDataFromPOST('distanceTraveled');
$dateOfRun = getDataFromPOST('dateOfRun');
$startAtTime = getDataFromPOST('startAtTime');
$finishAtTime = getDataFromPOST('finishAtTime');
$startLatitude = getDataFromPOST('startLatitude');
$startLongitude = getDataFromPOST('startLongitude');
$endLatitude = getDataFromPOST('endLatitude');
$endLongitude = getDataFromPOST('endLongitude');
$rating = getDataFromPOST('rating');
$note = getDataFromPOST('note');

// no null checking - already present in loginRequired()
$userID = getActiveUserID__FAKE();
$userActiveRouteID = findUsersActiveRoute($userID);

if ($userActiveRouteID === null) {
    //TODO redirect to active route setting
}

//TODO: Check if this is needed + if time is in right format!!! (HH:mm:ss)
$dateOfRun = date("Y-m-d");

$isSaved = saveRun($userID, $userActiveRouteID,
    $distanceTraveled,
    $dateOfRun,
    $startAtTime, $finishAtTime,
    $startLatitude, $startLongitude,
    $endLatitude, $endLongitude,
    $rating,
    $note);

if ($isSaved) {
    $status = RUN_SUCCESSFULLY_SAVED;

} else {
    $status = RUN_SAVING_FAILED;
}

// redirect to HOME PAGE with status message
redirectToHomePageWithMessage($status);


function getDataFromPOST($key) {
    if (isset($_POST[$key]) and $_POST[$key] !== "") {
        return $_POST[$key];
    } else {
        return null;
    }
}

function redirectToHomePageWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/homePage.php?status=' . $status);
}







