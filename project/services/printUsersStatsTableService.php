<?php

include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../template_utils/tableGenerator.php";
include_once "../services/calculateAverageSpeedService.php";


function getUserStatsTable($userID) {

    $userStats = getAllUsersRuns__FAKE($userID);

    if ($userStats === null) {
        return "No statistics found for given userID!";
    }

    $attrs = array("class" => "user-runs-table", "id" => "user-runs-table");
    $header = array("Date", "Start time", "Finish time", "Rating", "Distance", "Average speed", "Route");
    $content = array();

    foreach ($userStats as $stat) {

        if ($stat["startAtTime"] !== null and $stat["endAtTime"] !== null and $stat["distance"] !== null) {
            $averageSpeed = getAverageSpeedBetweenTimes($stat["startAtTime"], $stat["endAtTime"], $stat["distance"]);
        } else {
            $averageSpeed = null;
        }

        $row = array (
            getValueOrStringWhenNull($stat["date"], "No data"),
            getValueOrStringWhenNull($stat["startAtTime"], "No data"),
            getValueOrStringWhenNull($stat["endAtTime"], "No data"),
            getValueOrStringWhenNull($stat["rating"], "No data"),
            getValueOrStringWhenNull($stat["distance"], "No data") . " [km]",
            $averageSpeed !== null ? $averageSpeed . " [km/h]" : "Not enough data",
            getLinkToRoute($stat["routeID"], $stat["routeName"]),
        );

        array_push($content, $row);
    }

    return assembleTable($header, $content, $attrs);
}


function getLinkToRoute($routeID, $routeName) {
    return '<a href="../templates/singleRouteDetail.php?routeID=' . $routeID . '">' . $routeName . '</a>';
}

function getValueOrStringWhenNull($value, $string) {
    return $value !== null ? $value : $string;
}

