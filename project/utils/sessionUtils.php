<?php

define('ADMIN_ROLE', 'ADMIN');

function isUserAdmin_YES__FAKE() {
    return true;
}

function isUserAdmin() {

    return getActiveUserRole()["role"] == ADMIN_ROLE;

}

function getActiveUserID__FAKE() {
    return 42;
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

    if (!isset($_SESSION["userRole"])) {
        return null;
    }
    return $_SESSION["userRole"];
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
