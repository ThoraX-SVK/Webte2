<?php

include_once "../database/routeUtils.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/routeConstants.php";
include_once "../template_utils/tableGenerator.php";


function getRouteTables($userID = null) {

    if($userID == null) {
        $userID = getActiveUserID();
    }

    if ($userID === null) {
        // $userID is null somehow (loginRequired implies that it is not)
        return "FAILED: USER ID NOT GIVEN, USER IS NOT LOGGED IN.";
    }

    $tables = array();

    $privateRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID(PRIVATE_MODE, $userID), $userID, PRIVATE_MODE);
    $publicRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID(PUBLIC_MODE, $userID), $userID, PUBLIC_MODE);
    $teamRoutes = transformRouteArrayTo2D(getAllRoutesWithModeVisibleForUserID(TEAM_MODE, $userID), $userID, TEAM_MODE);


    $header = array("Name of route", "Total Distance", "Distance ran", "Distance remaining", "Activity", "Action");
    $htmlAttrs = array ("class" => "table-routes", "id" => "table-routes");

    $tables[PRIVATE_MODE] = assembleTable($header, $privateRoutes, $htmlAttrs);
    $tables[PUBLIC_MODE] = assembleTable($header, $publicRoutes, $htmlAttrs);
    $tables[TEAM_MODE] = assembleTable($header, $teamRoutes, $htmlAttrs);

    return $tables;
}


function transformRouteArrayTo2D($routes, $activeUserID, $mode) {

    $result = array();

    foreach ($routes as $route) {

        // assuming routes have been filtered before coming in from the DB
        $userCanJoin = $mode === TEAM_MODE ? $route["isUserInTeam"] : true;

        array_push($result,
            array(
            getLinkToRoute($route["routeID"], $route["name"]),
            $route["distanceData"]["totalDistance"] . " [km]",
            $route["distanceData"]["done"] . " [km]",
            $route["distanceData"]["remaining"] . " [km]",
            $route["isActiveForUser"] ? "Active" : "Inactive",
            getRouteAssignLink($route["routeID"], $activeUserID, $mode, $userCanJoin)
            ));
        }

    return $result;
}

function transformRouteArrayTo2D__ADMIN_VIEW($routes) {

    $result = array();

    foreach ($routes as $route) {

        array_push($result,
            array(
                getLinkToRoute($route["routeID"], $route["name"]),
                $route["distanceData"]["totalDistance"],
                $route["distanceData"]["done"],
                $route["distanceData"]["remaining"],
                getUserFromUserId($route['createdByUserID'])['email']
            ));
    }
    return $result;
}

function getAllTables() {

    $tables = array();

    $privateRoutes = transformRouteArrayTo2D__ADMIN_VIEW(getAllRoutesWithMode(PRIVATE_MODE));
    $publicRoutes = transformRouteArrayTo2D__ADMIN_VIEW(getAllRoutesWithMode(PUBLIC_MODE));
    $teamRoutes = transformRouteArrayTo2D__ADMIN_VIEW(getAllRoutesWithMode(TEAM_MODE));

    $header = array("Name of route", "Total Distance", "Distance ran", "Distance remaining", "Created by");
    $htmlAttrs = array ("class" => "table-routes", "id" => "table-routes");

    $tables[PRIVATE_MODE] = assembleTable($header, $privateRoutes, $htmlAttrs);
    $tables[PUBLIC_MODE] = assembleTable($header, $publicRoutes, $htmlAttrs);
    $tables[TEAM_MODE] = assembleTable($header, $teamRoutes, $htmlAttrs);

    return $tables;
}

function getLinkToRoute($routeID, $routeName) {
    return '<a href="../templates/singleRouteDetail.php?routeID=' . $routeID . '">' . $routeName . '</a>';
}

function getRouteAssignLink($routeID, $userID, $mode, $userCanJoin) {

    $link = '<a href="../controller/assignRouteToUser.php?routeID=' . $routeID . '&userID=' . $userID . '">Assign as active</a>';

    switch ($mode) {
        case TEAM_MODE:
            if ($userCanJoin) {
                return $link;
            } else {
                return "";
            }
        default:
            return $link;
    }
}


