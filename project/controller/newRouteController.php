<?php

include_once "../constants/routeConstants.php";

include_once '../utils/sessionUtils.php';
include_once '../database/routeUtils.php';

$distance= null;
$mode = null;
$team = null;

if(isset($_POST['distance'])) {
    $distance = $_POST['distance'];
}

if(isset($_POST['mode'])) {
    $mode = $_POST['mode'];
}

if(isset($_POST['teamID']) && $mode === TEAM_MODE) {
    $team = $_POST['teamID'];
}

$userId = getActiveUserID();

if($userId === null) {
    //TODO: Session is not initialized, move to login?
}

if($mode === null) {
    //TODO: Is this check even needed? Can user somehow hack POST so he does not post one value?
}

switch ($mode) {
    case PRIVATE_MODE:
        saveRoute($userId, $distance, $mode);
        break;

    case PUBLIC_MODE:
    case TEAM_MODE:
        if (isUserAdmin()) {
            saveRoute($userId, $distance, $mode);
        } else {
            //TODO: Give error message back?
        }
        break;

    default:
        break;
}













