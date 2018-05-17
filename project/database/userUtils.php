<?php

/**
 *  Every call to database that somehow handles users goes here
 */

include_once '../database/createConnection.php';
include_once '../security/saltGenerator.php';
include_once '../security/passwordHashGenerator.php';
include_once '../database/addressUtils.php';
include_once '../database/schoolUtil.php';

function createEmptyUser() {
    return array (
        "surname" => null,
        "name" => null,
        "email" => null,
        "password" => null,
        "passwordConfirm" => null,
        "schoolName" => null,
        "schoolCity" => null,
        "schoolStreet" => null,
        "schoolStreetNo" => null,
        "schoolPSC" => null,
        "schoolState" => null,
        "userStreet" => null,
        "userStreetNo" => null,
        "userPSC" => null,
        "userCity" => null,
        "userState" => null
    );
}

function getUserIdFromEmail__FAKE($email) {
    return 1;
}

/**
 * For testing purposes, substitute this for getUserIdFromEmail() too
 * see behaviour when user with given email is not in DB
 *
 * @param $email
 * @return null
 */
function getUserIdFromEmail_USER_NON_EXISTENT__FAKE($email) {
    return null;
}

/**
 * Returns userID for given email on NULL if email is not found
 *
 * @param $email
 * @return int|null
 */
function getUserIdFromEmail($email) {

    //TODO: Call DB, return email userID if there is, null if not

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT User.id FROM w2final.User WHERE email = ?");
    $stmn->bind_param("s",$email);
    $stmn->execute();

    $result = $stmn->get_result();

    if(mysqli_num_rows($result) === 0) {
        //Email not in DB
        return null;
    }

    $resultRow = $result->fetch_assoc();
    return $resultRow['id'];
}

function isEmailAlreadyInDatabase_TRUE__FAKE($email) {
    return true;
}

function isEmailAlreadyInDatabase_FALSE__FAKE($email) {
    return false;
}

function isEmailAlreadyInDatabase($email) {
    return getUserIdFromEmail($email) == null ? false : true;
}

function getUserFromUserId__FAKE($userID) {

//    //TODO: Add more stuff to represent user, might be class in future
//    return array(
//        'userID' => 1,
//        'passwordHash' => 'hash',
//        'salt' => 'salt',
//        'name' => 'Jozko',
//        'surname' => 'Mrkvicka',
//        'City' => 'Bratislava'
//    );
    return array(
        'salt' => 'salt',
        'passwordHash' => 'hash',
        'userID' => 1,
        'email' => "jebek@jebko.sk",
        'name' => "Jozin",
        'surname' => "Koko",
        'isActivated' => true
    );
}

function getUserFromUserId($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id AS 'userID', email AS 'email', name AS 'name', surname AS 'surname', isActivated AS 'isActivated',
                                    passwordSalt AS 'salt', passwordHash AS 'passwordHash'
                                    FROM w2final.User 
                                    WHERE id = ?");
    $stmn->bind_param("i", $userID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();

    return array(
        'salt' => $row['salt'],
        'passwordHash' => $row['passwordHash'],
        'userID' => $row['userID'],
        'email' => $row['email'],
        'name' => $row['name'],
        'surname' => $row['surname'],
        'isActivated' => $row['isActivated']
    );
}

function getUserRoleFromUserId($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT role_fk AS 'roleID' FROM w2final.User WHERE id = ?");
    $stmn->bind_param("i", $userID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['roleID'];
}

function getUserRoleFromUserId__FAKE($userID) {
    return array(
        'roleID' => 2,
        'role' => ADMIN_ROLE,
    );
}

function saveUserToDB_SUCCESS__FAKE($userData) {
    return 1;
}


/**
 *  Function saves user to DB returning his new userID or null if
 *  user was no saved successfully.
 *
 * @param $userData
 * @return int|null
 */
function saveUserToDB($userData) {

    $userSalt = generateSalt();
    $hashedPassword = computePasswordHash($userSalt,$userData['password']);

    $homeAddressId = getAddressIDSaveIfNeeded($userData['userStreet'],$userData['userStreetNo'],$userData['userCity'],$userData['userState'],$userData['userPSC']);
    $schoolAddressID = getAddressIDSaveIfNeeded($userData['schoolStreet'],$userData['schoolStreetNo'],$userData['schoolCity'],$userData['schoolState'],$userData['schoolPSC']);

    $schoolID = getSchoolIDSaveIfNecessary($userData['schoolName'], $schoolAddressID);

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.User VALUES (DEFAULT, ?, ?, FALSE, ?, ? , ?, ?, 1, null, ?)");
    $stmn->bind_param("sssssii",$userSalt,$hashedPassword, $userData['email'], $userData['name'], $userData['surname'], $homeAddressId, $schoolID);
    $isSaved = $stmn->execute();

    $stmn->close();
    $conn->close();

    if($isSaved) {
        return getUserIdFromEmail($userData['email']);
    } else {
        return null;
    }
}


function findUsersActiveRoute__FAKE($userID) {
    return 1;
}

function findUsersActiveRoute__FAKE_NULL($userID) {
    return null;
}

/**
 *  Based on given userID, function will find his active routeID to which
 *  he is currently contributing. If he is not contributing to any route
 *  function returns null.
 *
 * @param $userID
 * @return int|null
 */
function findUsersActiveRoute($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT activeRoute_fk FROM w2final.User WHERE activeRoute_fk = ?");
    $stmn->bind_param("i", $userID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['activeRoute_fk'];
}

/**
 * Activate account with givenID
 *
 * @param $userId
 */
function activateUserAccount($userId) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("UPDATE w2final.User SET isActivated = TRUE WHERE id = ?");
    $stmn->bind_param("i",$userId);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}


/**
 * Check whether user account is activated.
 *
 * @param $userId
 * @return bool
 */
function isUserActivated($userId) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT isActivated FROM w2final.User WHERE id = ? AND isActivated = TRUE");
    $stmn->bind_param("i",$userId);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();
    if(mysqli_num_rows($result) === 0) {
        return false;
    }

    return true;
}

function addRouteToTeam($teamID, $routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.TeamRoutes VALUES (?, ?)");
    $stmn->bind_param("ii", $teamID, $routeID);
    $stmn->execute();
    $stmn->close();
}

function getAllUsers() {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.User");
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    $res_arr = new ArrayObject();
    foreach ($result as $row) {
        $res = getUserFromUserId($row['id']);
        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}

function getAllUsers__FAKE() {
    $users = array();

    for ($i = 0; $i < 5; $i++) {
        array_push($users, getUserFromUserId__FAKE(1));
    }

    return $users;
}

function getAllUsersRuns__FAKE($userID) {

    return array(
                array (
                    'distance' => 10,
                    'date' => '2018-12-30',
                    'startAtTime' => '15:00:00',
                    'endAtTime' => '16:00:00',
                    'rating' => 5,
                    'routeID' => 1,
                    'routeName' => 'ROUTE_1'
                ),
                array (
                    'distance' => 20,
                    'date' => '2018-12-31',
                    'startAtTime' => '17:00:00',
                    'endAtTime' => '20:00:00',
                    'rating' => 3,
                    'routeID' => 2,
                    'routeName' => 'ROUTE_2'
                ),
                array (
                    'distance' => 10,
                    'date' => null,
                    'startAtTime' => null,
                    'endAtTime' => null,
                    'rating' => null,
                    'routeID' => 1,
                    'routeName' => 'ROUTE_1'
                )
            );
}

function getAllUsersRuns($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT Run.distance AS 'runDistance', date, startAtTime, endAtTime, rating, Route.id AS 'routeID', name
                                   FROM w2final.Run
                                      JOIN w2final.Route ON Run.route_fk = Route.id
                                   WHERE Run.user_fk = ?");
    $stmn->bind_param("i", $userID);
    $stmn->execute();

    $result = $stmn->get_result();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $res_arr = new ArrayObject();
    foreach ($result as $row) {

        $res = array (
            'distance' => $row['runDistance'],
            'date' => $row['date'],
            'startAtTime' => $row['startAtTime'],
            'endAtTime' => $row['endAtTime'],
            'rating' => $row['rating'],
            'routeID' => $row['routeID'],
            'routeName' => $row['name']
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}







