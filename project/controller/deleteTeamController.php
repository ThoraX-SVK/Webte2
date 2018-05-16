<?php

include_once '../utils/sessionUtils.php';
include_once '../database/teamUtils.php';
include_once '../constants/teamConstants.php';

loginRequired(ADMIN_ROLE);

$teamID = getDataFromGET("teamID");

//TODO uncomment when done
//deleteTeamFromDB($teamID);

redirectToAllTeamsWithMessage(TEAM_SUCCESSFULLY_DELETED);

function redirectToAllTeamsWithMessage($status) {
    header('location: ../templates/allTeams.php?status=' . $status);
}


function getDataFromGET($key) {
    if (isset($_GET[$key]) and $_GET[$key] !== "") {
        return $_GET[$key];
    } else {
        return null;
    }
}