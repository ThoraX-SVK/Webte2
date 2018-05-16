<?php

include_once "../constants/routeConstants.php";

include_once '../utils/sessionUtils.php';
include_once '../database/routeUtils.php';

$distance= getDataFromPOST('distance');
$name = getDataFromPOST('routeName');
$mode = getDataFromPOST('mode');
$team = getDataFromPOST('teamID');
$startLatitude = getDataFromPOST('startLatitude');
$startLongitude = getDataFromPOST('startLongitude');
$endLatitude = getDataFromPOST('endLatitude');
$endLongitude = getDataFromPOST('endLongitude');

$userId = getActiveUserID();

if($userId === null) {
    //TODO: Session is not initialized, move to login?
}

if($mode === null) {
    //TODO: Is this check even needed? Can user somehow hack POST so he does not post one value?
}

switch ($mode) {
    case PRIVATE_MODE:
        saveRoute($userId, $name, $distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    case PUBLIC_MODE:
    case TEAM_MODE:
        if (isUserAdmin()) {
            saveRoute($userId, $name ,$distance, $mode,
                $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        } else {
            //TODO: Give error message back?
        }
        break;

    default:
        break;
}

function getDataFromPOST($key) {
    if (isset($_POST[$key])) {
        return $_POST[$key];
    } else {
        return null;
    }
}













