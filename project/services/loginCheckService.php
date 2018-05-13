<?php

include_once "../database/userUtils.php";
include_once "../security/passwordHashGenerator.php";

/**
 * Always returns true
 *
 * @param $email
 * @param $password
 * @return bool
 */
function CheckLoginAlwaysTrue__FAKE($email, $password) {
    return true;
}

/**
 * Always returns false
 *
 * @param $email
 * @param $password
 * @return bool
 */
function CheckLoginAlwaysFalse__FAKE($email, $password) {
    return false;
}

/**
 * Returns true/false based on fact, if password matches to that user email
 *
 * @param $email
 * @param $password
 * @return bool
 */
function checkIfLoginCorrect($email, $password) {

    /**
     * Given email, check if user is in DB
     */
    $userID = getUserIdFromEmail__FAKE($email);

    if($userID == null) {
        /**
         * User does not exist in DB
         */
        return false;
    }

    $user = getUserFromUserId__FAKE($userID);

    $userPasswordHash = $user['passwordHash'];
    $computedLoginHash = computePasswordHash__FAKE($user['salt'], $password);

    if($userPasswordHash === $computedLoginHash) {
        return true;
    }

    return false;
}





