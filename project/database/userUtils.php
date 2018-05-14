<?php

/**
 *  Every call to database that somehow handles users goes here
 */

include_once '../database/createConnection.php';
include_once '../security/saltGenerator.php';
include_once '../security/passwordHashGenerator.php';

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

    //TODO: Add more stuff to represent user, might be class in future
    return array(
        'userID' => 1,
        'passwordHash' => 'hash',
        'salt' => 'salt',
        'name' => 'Jozko',
        'surname' => 'Mrkvicka',
        'City' => 'Bratislava'
    );
}

function getUserFromUserId($userID) {

    //TODO: Call DB, get real user data

    return null;
}

function getUserRoleFromUserId($userID) {
    //TODO: Call DB, get real user data
    return null;
}

function getUserRoleFromUserId__FAKE($userID) {
    return array(
        'roleID' => 1,
        'role' => ADMIN_ROLE,
    );
}

function saveUserToDB_SUCCESS__FAKE($email, $name, $surname, $password) {
    return 1;
}


/**
 *
 *  Function saves user to DB returning his new userID or null if
 *  user was no saved successfully.
 *
 * @param $email
 * @param $name
 * @param $surname
 * @param $password
 * @return int|null
 */
function saveUserToDB($email, $name, $surname, $password) {

    $userSalt = generateNewSalt__FAKE();
    $hashedPassword = computePasswordHash__FAKE($userSalt,$password);

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.User VALUES (DEFAULT, ?, ?, true, ?, ?, ?,null, 1)");
    $stmn->bind_param("sssss",$userSalt,$hashedPassword, $email, $name, $surname);
    $isSaved = $stmn->execute();

    $stmn->close();
    $conn->close();

    if($isSaved) {
        return getUserIdFromEmail($email);
    } else {
        return null;
    }
}


function findUsersActiveRoute__FAKE($userID) {
    return 1;
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
    $stmn = $conn->prepare("SELECT route_fk FROM w2final.UserActiveRoute WHERE user_fk = ?");
    $stmn->bind_param("i", $userID);
    $stmn->execute();

    $result = $stmn->get_result();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    return $result['route_fk'];
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


