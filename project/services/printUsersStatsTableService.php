<?php

include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";


function getUserStatsTable($userID) {

    $userStats = getUserStatistics__FAKE($userID);

    if ($userStats === null) {
        return "No statistics found for given userID!";
    }

    $attrs = array();
    $header = array();
    $content = array();


    return assembleTable($header, $content, $attrs);
}

//getUserStatistics__FAKE