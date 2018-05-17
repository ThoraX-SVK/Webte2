<?php

include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";


function getUserStatsTable($userID) {

    $userStats = getUserStatistics__FAKE($userID);

    if ($userStats === null) {
        return "No statistics found for given userID!";
    }

    $attrs = array("class" => "user-runs-table", "id" => "user-runs-table");
    $header = array("Date", "Start time", "Finish time", "Rating", "Distance", "Average speed");
    $content = array();

    $row = array (
        "date" => "",
        "timeOfStart" => "",
        "timeOfEnd" => "",
        "rating" => "",
        "distance" => "",
        "averageSpeed" => "",
    );

    return assembleTable($header, $content, $attrs);
}

