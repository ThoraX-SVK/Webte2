<?php

define('ADMIN_ROLE', 'ADMIN');
define('USER_ROLE', 'USER');
define('GUEST_ROLE', 'GUEST');


function isUserAdmin_YES__FAKE() {
    return true;
}

function isUserAdmin_FALSE__FAKE() {
    return false;
}

function isUserAdmin() {

    return getActiveUserRole() === ADMIN_ROLE;
}

function isUserLoggedIn() {
    return getActiveUserRole() !== GUEST_ROLE;
}

function isUserLoggedIn__TRUE__FAKE() {
    return true;
}

function getActiveUserID__FAKE() {
    return 42;
}

/**
 * Testing function, substitute it for getActiveUserID()
 * to test case when user did not set up his session yet.
 *
 * @return null
 */
function getActiveUserID_NO_SESSION__FAKE() {
    return null;
}

function getActiveUserID() {

    if (!isset($_SESSION["userID"])) {
        return null;
    }
    return $_SESSION["userID"];
}

function getActiveUserRole__FAKE() {
    return ADMIN_ROLE;
}

function getActiveUserRole() {

    // not logged in
    if (!isset($_SESSION["userID"]) or !isset($_SESSION["userEmail"]) or !isset($_SESSION["userRole"])) {
        return GUEST_ROLE;
    }

    // logged in
    if ($_SESSION["userRole"] === ADMIN_ROLE) {
        return ADMIN_ROLE;
    } else {
        return USER_ROLE;
    }

}

/**
 * sets $_SESSION parameters such as user email (for identification) and user role (regular or admin)
 * @param $userID
 * @param $email
 * @param $userRole
 */
function createUserSession($userID, $email, $userRole) {

    $_SESSION["userID"] = $userID;
    $_SESSION["userEmail"] = $email;
    $_SESSION["userRole"] = $userRole;

}

/**
 * redirects user to login page if they have not logged in yet
 * @param null $role - if ADMIN_ROLE then a check is made
 */
function loginRequired($role = null) {

    if ($role === ADMIN_ROLE) {
        if (!isUserLoggedIn__TRUE__FAKE() or !isUserAdmin_YES__FAKE()) {
            header('location: ../templates/login.php?status=' . ADMIN_REQUIRED);
            exit;
        }
    }

    if (!isUserLoggedIn__TRUE__FAKE()) {
        header('location: ../templates/login.php?status=' . LOGIN_REQUIRED);
        exit;
    }
}



