<?php

include_once "../utils/sessionUtils.php";
include_once "../database/userUtils.php";
include_once "../database/runUtils.php";
include_once "../constants/loginConstants.php";
include_once "../constants/messageConstants.php";

// check if user logged in, redirect to login if false
loginRequired();

$distanceTraveled = getDataFromPOST('distance');
$dateOfRun = getDataFromPOST('dateOfRun');
$startAtTime = getDataFromPOST('startAtTime');
$finishAtTime = getDataFromPOST('finishAtTime');
$origin = getDataFromPOST('origin');
$destination = getDataFromPOST('destination');
$rating = getDataFromPOST('rating');
$note = getDataFromPOST('note');

$start = addressToLatLong($origin);
$end = addressToLatLong($destination);
$startLatitude = $start[0];
$startLongitude = $start[1];
$endLatitude = $end[0];
$endLongitude = $end[1];


// no null checking - already present in loginRequired()
$userID = getActiveUserID();
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

function addressToLatLong($dlocation){
    $address = str_replace(',','',$dlocation);
    $prepAddr = str_replace(' ','+',$address);
    //$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=true_or_false&key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4');
    $output= json_decode($geocode);
    $latlon[0] = $output->results[0]->geometry->location->lat;
    $latlon[1] = $output->results[0]->geometry->location->lng;
    return $latlon;
}







