<?php

include_once "../utils/sessionUtils.php";
include_once "../database/routeUtils.php";


function isRouteVisibleToUser($userID, $routeID) {

    if (isUserAdmin()) {
        return true;
    } else {
        return isRouteVisibleForUserID($routeID, $userID);
    }

}