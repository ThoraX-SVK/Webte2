<?php

include_once '../utils/sessionUtils.php';
include_once '../database/teamUtils.php';
include_once '../constants/teamConstants.php';
include_once '../constants/globallyUsedConstants.php';

loginRequired(ADMIN_ROLE);


$teamName = getDataFromPOST('teamName');
$teamMembersIDs = getDataFromPOST('userID');


if (!nullCheck(array($teamName)) or sizeof($teamMembersIDs) == 0) {
    redirectToNewTeamPageWithMessage(NOT_ENOUGH_DATA);
    return;
}

$teamMembersIDs = array_unique($teamMembersIDs, SORT_NUMERIC );
$teamMembers = array();
foreach ($teamMembersIDs as $memberID) {
    array_push($teamMembers, array("userID" => $memberID));
}

// prepare teamData and save to DB
$teamData = array(
    "teamName" => $teamName,
    "teamMembers" => $teamMembers
);

$teamID = saveTeamToDB($teamData);
if ($teamID === null) {
    redirectToNewTeamPageWithMessage(TEAM_SAVING_FAILED);
    return;
}


redirectToAllTeamsWithMessage(TEAM_SUCCESSFULLY_SAVED);


function getDataFromPOST($key) {
    if (isset($_POST[$key]) and $_POST[$key] !== "") {
        return $_POST[$key];
    } else {
        return null;
    }
}

function redirectToAllTeamsWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/allTeams.php?status=' . $status);
}

function redirectToNewTeamPageWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/newTeamPage.php?status=' . $status);
}

function nullCheck($array) {
    foreach ($array as $item) {
        if ($item === null) {
            return false;
        }
    }
    return true;
}











