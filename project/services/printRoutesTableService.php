<?php

include_once "../database/routeUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/routeConstants.php";
include_once "../template_utils/tableGenerator.php";

loginRequired();

//var_dump(getRouteTables());

function getRouteTables() {

    //TODO: Slight change, userID CAN NOT be null.
    if (!isUserAdmin_YES__FAKE()) {
        $userID = getActiveUserID();
    } else {
        $userID = null;
    }

    $tables = array();
    $privateRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID(PRIVATE_MODE, $userID));
    $publicRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID(PUBLIC_MODE, $userID));

    //TODO: Return value changed a bit, please see function. Now returns, whether user is in team to allow/bock him from
    //TODO: assigning that route
    $teamRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID__FAKE(TEAM_MODE, $userID));

    $header = array("Name of route", "Total Distance", "Distance ran", "Distance remaining", "Activity");
    $htmlAttrs = array ("class" => "table-routes", "id" => "table-routes");

    $tables[PRIVATE_MODE] = assembleTable($header, $privateRoutes, $htmlAttrs);
    $tables[PUBLIC_MODE] = assembleTable($header, $publicRoutes, $htmlAttrs);
    //$tables[TEAM_MODE] = assembleTable($header, $teamRoutes, $htmlAttrs);

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


