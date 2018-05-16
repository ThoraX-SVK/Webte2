<?php

include_once "../constants/routeConstants.php";
include_once '../utils/sessionUtils.php';
include_once '../database/routeUtils.php';

loginRequired();


$distance= getDataFromPOST('distance');
$name = getDataFromPOST('routeName');
$mode = getDataFromPOST('mode');
$team = getDataFromPOST('teamID');
$startLatitude = getDataFromPOST('startLatitude');
$startLongitude = getDataFromPOST('startLongitude');
$endLatitude = getDataFromPOST('endLatitude');
$endLongitude = getDataFromPOST('endLongitude');

$userId = getActiveUserID();

switch ($mode) {
    case PRIVATE_MODE:
        saveRoute_FAKE($userId, $name, $distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    case PUBLIC_MODE:
    case TEAM_MODE:
        if (isUserAdmin()) {
            saveRoute_FAKE($userId, $name ,$distance, $mode,
                $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        } else {
            loginRequired(ADMIN_ROLE);
        }
        break;

    default:
        break;
}

redirectToHomePageWithMessage(ROUTE_SUCCESSFULLY_SAVED);


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












