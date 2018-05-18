<?php

include_once '../database/createConnection.php';


function saveTeamToDB($teamData) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.Team VALUES (DEFAULT , ?)");
    $stmn->bind_param("s", $teamData['teamName']);
    $stmn->execute();
    $stmn->close();
    $teamID = getTeamIdFromTeamName($teamData['teamName']);

    if($teamID === null) {
        return null;
    }

    foreach ($teamData['teamMembers'] as $member) {
        addUserToTeam($conn, $teamID, $member['userID']);
    }

    $conn->close();

    return $teamID;
}

function addUserToTeam(mysqli $conn, $teamID, $userID) {

    $stmn = $conn->prepare("INSERT w2final.TeamMembers VALUES (?, ?)");
    $stmn->bind_param("ii", $teamID, $userID);
    $stmn->execute();
    $stmn->close();
}

function addUserToTeamSeparate($teamID, $userID) {
    $conn = createConnectionFromConfigFileCredentials();

    addUserToTeam($conn, $teamID, $userID);
    $conn->close;
}

function getTeamIdFromTeamName__FAKE($teamName) {
    return 1;
}

function getTeamIdFromTeamName($teamName) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.Team WHERE name = ?");
    $stmn->bind_param("s", $teamName);
    $stmn->execute();

    $result = $stmn->get_result();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function isTeamNameAlreadyInDB_YES__FAKE($teamName) {
    return true;
}

function isTeamNameAlreadyInDB_NO__FAKE($teamName) {
    return false;
}

/**
 * If team name is already in DB, return false.
 * If it is free to take, return true.
 *
 * @param $teamName
 * @return bool
 */
function isTeamNameAlreadyInDB($teamName) {

    return getTeamIdFromTeamName($teamName) === null ? false : true;
}

function getTeamInfo($teamID) {

    $conn = createConnectionFromConfigFileCredentials();

    $stmn = $conn->prepare("SELECT name AS 'teamName', user_fk AS 'userID'
                                   FROM w2final.Team
                                      LEFT JOIN w2final.TeamMembers ON Team.id = TeamMembers.team_fk
                                   WHERE id = ?");
    $stmn->bind_param("i",$teamID);
    $stmn->execute();

    $result = $stmn->get_result();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $teamName = null;
    $teamMembersArr = new ArrayObject();
    foreach ($result as $member) {
        $teamName = $member['teamName'];

        if($member['userID'] === null) {
            continue;
        }

        $memberArr = array(
            'userID' => $member['userID']
        );

        $teamMembersArr->append($memberArr);
    }

    return array (
        'teamName' => $teamName,
        'teamMembers' => $teamMembersArr->getArrayCopy()
    );
}

function getTeamIdFromRouteID($routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT team_fk AS 'teamID' FROM w2final.TeamRoutes WHERE route_fk = ?");
    $stmn->bind_param("i", $routeID);
    $stmn->execute();

    $result = $stmn->get_result();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['teamID'];
}

function getAllTeams__FAKE()
{

    return array(
        array(
            "teamID" => 1,
            "teamName" => "team 1",
            "teamMembers" => array(
                array("userID" => 1),
                array("userID" => 2),)
        ),
        array(
            "teamID" => 1,
            "teamName" => "team 2",
            "teamMembers" => array(
                array("userID" => 1),
                array("userID" => 5),
                array("userID" => 8),
                array("userID" => 11),)
        ),
        array(
            "teamID" => 1,
            "teamName" => "team 3",
            "teamMembers" => array(
                array("userID" => 3),
                array("userID" => 4),
                array("userID" => 5),)
        )
    );
}

function getAllTeams() {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.Team");
    $stmn->execute();

    $result = $stmn->get_result();

    $res_arr = new ArrayObject();
    foreach ($result as $row) {
        $res = getTeamInfo($row['id']);
        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}


function deleteUserFromTeam($teamID, $userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("DELETE FROM w2final.TeamMembers WHERE user_fk = ? AND team_fk = ? ");
    $stmn->bind_param("ii", $userID, $teamID);
    $stmn->execute();
}

function isUserInTeam($teamID, $userID) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT team_fk, user_fk FROM w2final.TeamMembers WHERE user_fk = ? AND team_fk = ?");
    $stmn->bind_param("ii", $userID, $teamID);
    $stmn->execute();

    $result = $stmn->get_result();

    return mysqli_num_rows($result) !== 0;

}
