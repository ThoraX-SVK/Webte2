<?php

include_once "../database/teamUtils.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/teamConstants.php";
include_once "../constants/globallyUsedConstants.php";


loginRequired(ADMIN_ROLE);


if (isset($_GET["userID"]) and isset($_GET["teamID"])) {
    $userID = $_GET["userID"];
    $teamID = $_GET["teamID"];
} else {
    redirectToAllTeamsWithMessage();
}

deleteUserFromTeam($teamID, $userID);
redirectToAllTeamsWithMessage(TEAM_MEMBER_REMOVED);



function redirectToAllTeamsWithMessage($status = null) {
    if ($status === null) {
        header('location: ../templates/allTeams.php');
    } else {
        header('location: ../templates/allTeams.php?status=' . $status);
    }
}