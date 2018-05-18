<?php

include_once "../template_utils/tableGenerator.php";
include_once "../database/routeUtils.php";
include_once "../database/userUtils.php";
include_once "../services/printRoutesTableService.php";
include_once "../constants/routeConstants.php";


function getLastRunsTable($routeID) {

    $lastRuns = get_N_lastRuns($routeID);

    


    $header = array("User", "Distance ran", "Date", "Finished At");


    $htmlAttrs = array("class" => "last-runs-table");
    $tableContent = array();

    foreach ($lastRuns as $run) {
        $user = getUserFromUserId($run["userID"]);
        if ($user === null or sizeof($user) === 0) {
            continue;
        }

        $tableRow = array(
            $user["name"] . " " . $user["surname"] . " - " . $user["email"],
            $run["distance"] . " km",
            $run["date"],
            $run["endAtTime"]

        );
        array_push($tableContent, $tableRow);
    }

    return assembleTable($header, $tableContent, $htmlAttrs);
}


function getTopContributors($routeID) {
    $topCont = get_N_topContributorsToRouteID($routeID);
    $header = array("Name", "Surname", "Email", "Contribution");
    $htmlAttrs = array("class" => "top-contributors-table");
    $tableContent = array();

    foreach ($topCont as $cont) {
        $user = getUserFromUserId($cont["userID"]);
        if ($user === null or sizeof($user) === 0) {
            continue;
        }

        $tableRow = array(
            $user["name"],
            $user["surname"],
            $user["email"],
            $cont["distance"]

        );
        array_push($tableContent, $tableRow);
    }

    return assembleTable($header, $tableContent, $htmlAttrs);
}


function getFullRouteDescription($routeID) {

    $desc = getRouteFullDescription($routeID);

    switch ($desc["routeMode"]) {
        case PRIVATE_MODE:
            $desc["routeMode"] = "Private mode";
            break;
        case PUBLIC_MODE:
            $desc["routeMode"] = "Public mode";
            break;
        case TEAM_MODE:
            $desc["routeMode"] = "Team mode";
            break;
        default:
            $desc["routeMode"] = "Unknown mode - this is not supposed to happen";
            break;
    }

    return $desc;

}


