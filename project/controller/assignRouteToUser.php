<?php

include_once "../database/routeUtils.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/routeConstants.php";
include_once "../constants/globallyUsedConstants.php";


loginRequired();

$routeID = getDataFromGET("routeID");
$userID = getDataFromGET("userID");

// check values
if ($routeID === null or $userID === null) {
    redirectToAllRoutesWithMessage(NOT_ENOUGH_DATA);
    return;
}

// check if both route and user exist
if (getRouteMode($routeID) === null or getUserFromUserId($userID) === null) {

    redirectToAllRoutesWithMessage(NOT_ENOUGH_DATA);
    return;
}

// check for duplicity
if (findUsersActiveRoute($userID) == $routeID) {
    redirectToAllRoutesWithMessage(ROUTE_ALREADY_ASSIGNED);
    return;
}

// ready to set
$isSucc = setUserActiveRoute($userID, $routeID);

if ($isSucc) {
    redirectToAllRoutesWithMessage(ROUTE_ASSIGNED);
} else {
    redirectToAllRoutesWithMessage(ROUTE_NOT_ASSIGNED);
}

// methods
function redirectToAllRoutesWithMessage($status = null) {
    if ($status === null) {
        header('location: ../templates/allRoutes.php');
    } else {
        header('location: ../templates/allRoutes.php?status=' . $status);
    }
}


function getDataFromGET($key) {
    if (isset($_GET[$key])) {
        return $_GET[$key];
    } else {
        return null;
    }
}