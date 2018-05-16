<?php

include_once "../template_utils/tableGenerator.php";
include_once "../database/routeUtils.php";
include_once "../database/userUtils.php";
include_once "../services/printRoutesTableService.php";
include_once "../constants/routeConstants.php";


function getLastRunsTable($routeID) {

    $lastRuns = get_N_lastRuns__FAKE($routeID);
    $header = array("User", "Distance ran", "Date", "Finishing time");
    $htmlAttrs = array("class" => "last-runs-table");
    $tableContent = array();

    foreach ($lastRuns as $run) {
        $user = getUserFromUserId__FAKE($run["userID"]);
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


