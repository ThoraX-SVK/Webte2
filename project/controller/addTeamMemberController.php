<?php

include_once "../database/teamUtils.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/teamConstants.php";
include_once "../constants/globallyUsedConstants.php";


loginRequired(ADMIN_ROLE);

$teamID = getDataFromPOST("teamID");
$userID = getDataFromPOST("userID");

// check values
if ($teamID === null or $userID === null) {
    redirectToAllTeamsWithMessage(NOT_ENOUGH_DATA);
    return;
}

// check if both team and user exist
if (getTeamInfo($teamID) === null or getUserFromUserId($userID) === null) {
    redirectToAllTeamsWithMessage(NOT_ENOUGH_DATA);
    return;
}

// check for duplicity
if (isUserInTeam($teamID, $userID)) {
    redirectToAllTeamsWithMessage(TEAM_MEMBER_ALREADY_EXISTS);
    return;
}

// ready to go
addUserToTeamSeparate($teamID, $userID);
redirectToAllTeamsWithMessage(TEAM_MEMBER_ADDED);


function redirectToAllTeamsWithMessage($status = null) {
    if ($status === null) {
        header('location: ../templates/allTeams.php');
    } else {
        header('location: ../templates/allTeams.php?status=' . $status);
    }
}


function getDataFromPOST($key) {
    if (isset($_POST[$key]) and $_POST[$key] !== "") {
        return $_POST[$key];
    } else {
        return null;
    }
}