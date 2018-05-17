<?php

include_once "../database/routeUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/routeConstants.php";
include_once "../template_utils/tableGenerator.php";


function getRouteTables() {

    //TODO: Slight change, userID CAN NOT be null.
    $userID = getActiveUserID__FAKE();
    if ($userID === null) {
        // $userID is null somehow (loginRequired implies that it is not)
        return "FAILED: USER ID NOT GIVEN, USER IS NOT LOGGED IN.";
    }

    $tables = array();
    $privateRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID__FAKE(PRIVATE_MODE, $userID));
    $publicRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID__FAKE(PUBLIC_MODE, $userID));

    //TODO: Return value changed a bit, please see function. Now returns, whether user is in team to allow/bock him from
    //TODO: assigning that route
    $teamRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID__FAKE(TEAM_MODE, $userID));

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


