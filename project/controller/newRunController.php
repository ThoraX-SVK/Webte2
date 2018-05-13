<?php

include_once "../utils/sessionUtils.php";
include_once "../database/userUtils.php";
include_once "../database/runUtils.php";



$userID = getActiveUserID__FAKE();

if($userID === null) {
    //TODO: session Is not created, do not let user continue
    //TODO: Print some kind of error? Redirect him to login page?
}

$distanceTraveled = null;
$dateOfRun = null;
$startAtTime = null;
$finishAtTime = null;
$startLatitude = null;
$startLongitude = null;
$endLatitude = null;
$endLongitude = null;
$rating = null;
$note = null;

if(!isset($_POST['distanceTraveled'])) {
    //TODO: Redirect to some kind of error, because distance is no set?
    //TODO: Is this even needed here?
}
$distanceTraveled = $_POST['distanceTraveled'];

if(isset($_POST['dateOfRun'])) {
    $dateOfRun = $_POST['dateOfRun'];
}

if(isset($_POST['startAtTime'])) {
    $startAtTime = $_POST['startAtTime'];
}

if(isset($_POST['finishAtTime'])) {
    $finishAtTime = $_POST['finishAtTime'];
}

if(isset($_POST['startLatitude'])) {
    $startLatitude = $_POST['startLatitude'];
}

if(isset($_POST['startLongitude'])) {
    $startLongitude = $_POST['startLongitude'];
}

if(isset($_POST['endLatitude'])) {
    $endLatitude = $_POST['endLatitude'];
}

if(isset($_POST['endLongitude'])) {
    $endLongitude = $_POST['endLongitude'];
}

if(isset($_POST['rating'])) {
    $rating = $_POST['rating'];
}

if(isset($_POST['note'])) {
    $note = $_POST['note'];
}

//TODO: What if user is newly registered and did not choose any route yet, so this is null?
$userActiveRouteID = findUsersActiveRoute__FAKE($userID);

//TODO: Check if this is needed + if time is in right format!!! (HH:mm:ss)
$dateOfRun = date("Y-m-d");

$isSaved = saveRun__FAKE($userID, $userActiveRouteID,
    $distanceTraveled,
    $dateOfRun,
    $startAtTime,$finishAtTime,
    $startLatitude,$startLongitude,
    $endLatitude,$endLongitude,
    $rating,
    $note);

if($isSaved) {
    //TODO: Redirect user to his home page with message that run was saved
} else {
    //TODO: Tell him that something went wrong
}


