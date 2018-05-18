<?php

include_once "../constants/routeConstants.php";
include_once "../template_utils/selectGenerator.php";
include_once "../utils/sessionUtils.php";
include_once "../database/teamUtils.php";


function getTeamsSelect() {

    $attrs = array("name" => "team");
    $options = array();

    $teams = getAllTeams();

    foreach ($teams as $team) {
        $teamID = getTeamIdFromTeamName($team["teamName"]);
        $opt = array(
            "value" => $teamID,
            "inner" => $team["teamName"],
        );

        array_push($options, $opt);
    }

    return assembleSelect($options, $attrs);
}
