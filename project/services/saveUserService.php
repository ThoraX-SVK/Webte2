<?php

include_once "../utils/EmailValidator.php";
include_once "../database/userUtils.php";
include_once "../constants/registerConstants.php";
include_once "../constants/globallyUsedConstants.php";


function saveUserSuccess__FAKE($email, $name, $surname, $password, $passwordConfirm) {

    return array(
        "status" => SUCCESS,
        "userID" => 42
    );
}

function saveUserFail__FAKE($email, $name, $surname, $password, $passwordConfirm) {

    return array(
        "status" => FAILED,
        "reason" => ERROR_SAVING_FAIL
    );
}

function saveUser($email, $name, $surname, $password, $passwordConfirm) {

    if (!isPasswordMatched($password, $passwordConfirm)) {
        // password and confirm password are different
        return array(
            "status" => FAILED,
            "reason" => ERROR_PASSWORD_MISMATCH
        );
    }

    if (!isEmailValid($email)) {
        //Email not valid
        return array(
            "status" => FAILED,
            "reason" => ERROR_EMAIL_INVALID
        );
    }

    if (isEmailAlreadyInDatabase($email)) {
        //Email is in DB
        return array(
            "status" => FAILED,
            "reason" => ERROR_EMAIL_TAKEN
        );
    }

    $newUserID = saveUserToDB($email, $name, $surname, $password);

    if ($newUserID === null) {
        //Something went wrong?
        return array(
            "status" => FAILED,
            "reason" => ERROR_SAVING_FAIL
        );
    }

    return array(
        "status" => SUCCESS,
        "userID" => $newUserID
    );
}


function saveUserWithAdditionalData($userData) {

    $email = $userData["email"];

    if (!isEmailValid($email)) {
        //Email not valid
        return array(
            "status" => FAILED,
            "reason" => ERROR_EMAIL_INVALID
        );
    }

    if (isEmailAlreadyInDatabase($email)) {
        //Email is in DB
        return array(
            "status" => FAILED,
            "reason" => ERROR_EMAIL_TAKEN
        );
    }

    $userID = saveUserAdditionalDataToDB__FAKE($userData);

    return array(
        "status" => SUCCESS,
        "userID" => $userID
    );
}

function saveUserWithAdditionalData__SUCCESS__FAKE($userData) {

    return array(
        "status" => SUCCESS,
        "userID" => 1
    );
}

function isPasswordMatched($password, $passwordConfirm) {
    return $password == $passwordConfirm;
}

