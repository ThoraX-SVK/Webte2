<?php

include_once "../constants/routeConstants.php";
include_once '../utils/sessionUtils.php';
include_once '../database/routeUtils.php';
include_once '../database/teamUtils.php';

loginRequired();

$distance= getDataFromPOST('distance');
$name = getDataFromPOST('routeName');
$mode = getDataFromPOST('mode');
$teamID = getDataFromPOST('team');
$origin = getDataFromPOST('origin');
$destination = getDataFromPOST('destination');
$start = addressToLatLong($origin);
$end = addressToLatLong($destination);
$startLatitude = $start[0];
$startLongitude = $start[1];
$endLatitude = $end[0];
$endLongitude = $end[1];

$userId = getActiveUserID();

if (!nullCheck(array($distance, $name, $mode, $startLatitude, $startLongitude, $endLatitude, $endLongitude))) {
    redirectToNewRoutePageWithMessage(NOT_ENOUGH_DATA);
    return;
}

switch ($mode) {
    case PRIVATE_MODE:
        saveRoute($userId, $name, $distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    case TEAM_MODE:
        if ($teamID === null) {
            redirectToNewRoutePageWithMessage(TEAM_REQUIRED);
            return;
        }

        loginRequired(ADMIN_ROLE);

        saveRoute($userId, $name ,$distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);

        $routeID = getRouteIDForRouteName($name);

        if($routeID !== null and $teamID !== null) {
            addRouteToTeam($teamID, $routeID);
        }
        break;

    case PUBLIC_MODE:
        loginRequired(ADMIN_ROLE);
        saveRoute($userId, $name ,$distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    default:
        break;
}

redirectToAllRoutesWithMessage(ROUTE_SUCCESSFULLY_SAVED);


function getDataFromPOST($key) {
    if (isset($_POST[$key]) and $_POST[$key] !== "") {
        return $_POST[$key];
    } else {
        return null;
    }
}

function redirectToAllRoutesWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/allRoutes.php?status=' . $status);
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











