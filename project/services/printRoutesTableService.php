<?php

include_once "../database/routeUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/routeConstants.php";
include_once "../template_utils/tableGenerator.php";

loginRequired();

function getRoutesWithMode($mode) {
    return array();
}

function getRouteTables() {

    if (!isUserAdmin_YES__FAKE()) {
        $userID = getActiveUserID();
    } else {
        $userID = null;
    }

    $tables = array();
    $privateRoutes = transformRouteArrayTo2D(getAllRoutesWithMode__FAKE(PRIVATE_MODE, $userID));
    $publicRoutes = transformRouteArrayTo2D(getAllRoutesWithMode__FAKE(PUBLIC_MODE, $userID));
    $teamRoutes = transformRouteArrayTo2D(getAllRoutesWithMode__FAKE(TEAM_MODE, $userID));

    $header = array("Name of route", "Total Distance", "Distance ran", "Distance remaining", "Activity");
    $htmlAttrs = array ("class" => "table-routes", "id" => "table-routes");

    $tables[PRIVATE_MODE] = assembleTable($header, $privateRoutes, $htmlAttrs);
    $tables[PUBLIC_MODE] = assembleTable($header, $publicRoutes, $htmlAttrs);
    $tables[TEAM_MODE] = assembleTable($header, $teamRoutes, $htmlAttrs);

    return $tables;
}


function transformRouteArrayTo2D($routes) {

    $result = array();

    foreach ($routes as $route) {

        array_push($result,
            array(
            $route["name"],
            $route["distanceData"]["totalDistance"],
            $route["distanceData"]["done"],
            $route["distanceData"]["remaining"],
            $route["isActiveForUser"] ? "Active" : "Inactive",
            ));
        }

    return $result;
}


