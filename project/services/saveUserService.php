<?php

include_once "../utils/EmailValidator.php";
include_once "../database/userUtils.php";
include_once "../constants/registerConstants.php";
include_once "../constants/globallyUsedConstants.php";


function saveUserSuccess__FAKE($userData) {

    return array(
        "status" => SUCCESS,
        "userID" => 42
    );
}

function saveUserFail__FAKE($userData) {

    return array(
        "status" => FAILED,
        "reason" => ERROR_SAVING_FAIL
    );
}

function saveUser($userData) {

    if (!isPasswordMatched($userData['password'], $userData['passwordConfirm'])) {
        // password and confirm password are different
        return array(
            "status" => FAILED,
            "reason" => ERROR_PASSWORD_MISMATCH
        );
    }

    if (!isEmailValid($userData['email'])) {
        //Email not valid
        return array(
            "status" => FAILED,
            "reason" => ERROR_EMAIL_INVALID
        );
    }

    if (isEmailAlreadyInDatabase($userData['email'])) {
        //Email is in DB
        return array(
            "status" => FAILED,
            "reason" => ERROR_EMAIL_TAKEN
        );
    }

    $newUserID = saveUserToDB($userData);

    if ($newUserID === null) {
        //Something went wrong?
        return array(
            "status" => FAILED,
            "reason" => ERROR_SAVING_FAIL
        );
    }

    // remove if emails are implemented
    activateUserAccount($newUserID);

    return array(
        "status" => SUCCESS,
        "userID" => $newUserID
    );
}


function isPasswordMatched($password, $passwordConfirm) {
    return $password == $passwordConfirm;
}

