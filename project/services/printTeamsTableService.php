<?php

include_once "../database/teamUtils.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../template_utils/tableGenerator.php";


function getTeamTables() {

    $tables = array();
    $teams = getAllTeams();

    if (sizeof($teams) === 0) {
        return array("No teams in database");
    }

    $header = array("User ID", "Name", "Surname", "Email", "Is active", "Action");
    $htmlAttrs = array ("class" => "table-team");

    foreach ($teams as $team) {
        $teamID = getTeamIdFromTeamName($team["teamName"]);
        $tableData = array();

        if (!array_key_exists("teamName", $team) or !array_key_exists("teamMembers", $team)) {
            continue;
        }

        // handle team members, transform into array and push to $tableData
        foreach ($team["teamMembers"] as $member) {
            $user = getUserFromUserId($member["userID"]);

            $memberData = array(
                $user["userID"],
                $user["email"],
                $user["name"],
                $user["surname"],
                $user["isActivated"] ? "Activated" : "Not activated",
                getDeleteMemberLink($teamID, $user["userID"])
            );
            array_push($tableData, $memberData);
        }

        // push team info (id, name, members table) to $tables
        array_push($tables, array(
            "teamID" => $teamID,
            "teamName" => $team["teamName"],
            "table" => assembleTable($header, $tableData, $htmlAttrs)
        ));

    }


    return $tables;
}

function getDeleteMemberLink($teamID, $userID) {

    return '<a href="../controller/removeTeamMemberController.php?teamID=' . $teamID . '&userID=' . $userID . '">Remove</a>';

}





