<?php

include_once "../database/userUtils.php";
include_once "../database/routeUtils.php";

function printUserActiveRouteMap__FAKE($userID) {
    // this should call some api and show some predefined map
}

function printUserActiveRouteMap($userID) {

    $routeID = findUsersActiveRoute__FAKE($userID);

    printRouteMap__FAKE($routeID);
}


function printRouteMap__FAKE($routeID) {
    // this should call some api and show some predefined map
}

function printRouteMap($routeID) {

    $mapInfo = getRouteInfoForMapAPI__FAKE($routeID);

    //TODO: Construct API call here
}



