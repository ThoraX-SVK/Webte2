<?php

include_once "../constants/routeConstants.php";
include_once '../utils/sessionUtils.php';
include_once '../database/routeUtils.php';

loginRequired();


$distance= getDataFromPOST('distance');
$name = getDataFromPOST('routeName');
$mode = getDataFromPOST('mode');
$team = getDataFromPOST('team');
$startLatitude = getDataFromPOST('startLatitude');
$startLongitude = getDataFromPOST('startLongitude');
$endLatitude = getDataFromPOST('endLatitude');
$endLongitude = getDataFromPOST('endLongitude');

$userId = getActiveUserID();

if (!nullCheck(array($distance, $name, $mode, $startLatitude, $startLongitude, $endLatitude, $endLongitude))) {
    redirectToHomePageWithMessage(NOT_ENOUGH_DATA);
    return;
}

switch ($mode) {
    case PRIVATE_MODE:
        saveRoute_FAKE($userId, $name, $distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    case TEAM_MODE:
        if ($team === null) {
            redirectToNewRoutePageWithMessage(TEAM_REQUIRED);
            return;
        }

        loginRequired(ADMIN_ROLE);
        saveRoute_FAKE($userId, $name ,$distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);

        //TODO assign Team to Route and check if team exists

        break;

    case PUBLIC_MODE:
        loginRequired(ADMIN_ROLE);
        saveRoute_FAKE($userId, $name ,$distance, $mode,
                $startLatitude, $startLongitude, $endLatitude, $endLongitude);
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

function redirectToNewRoutePageWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/newRoutePage.php?status=' . $status);
}

function nullCheck($array) {
    foreach ($array as $item) {
        if ($item === null) {
            return false;
        }
    }
    return true;
}











