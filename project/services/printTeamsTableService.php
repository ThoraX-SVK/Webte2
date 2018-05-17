<?php

include_once "../database/teamUtils.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../template_utils/tableGenerator.php";


function getTeamTables() {

    $tables = array();
    $teams = getAllTeams__FAKE();

    $header = array("User ID", "Name", "Surname", "Email", "Is active");
    $htmlAttrs = array ("class" => "table-team");

    foreach ($teams as $team) {
        $tableData = array();

        if (!array_key_exists("teamName", $team) or !array_key_exists("teamMembers", $team)) {
            continue;
        }

        foreach ($team["teamMembers"] as $member) {
            $user = getUserFromUserId($member["userID"]);

            $memberData = array(
                $user["userID"],
                $user["email"],
                $user["name"],
                $user["surname"],
                $user["isActivated"] ? "Activated" : "Not activated"
            );
            array_push($tableData, $memberData);
        }

       $tables[$team["teamName"]] = assembleTable($header, $tableData, $htmlAttrs);
    }


    return $tables;
}




