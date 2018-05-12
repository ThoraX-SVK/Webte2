<?php

include_once "../utils/EmaiValidator.php";
include_once "../database/userUtils.php";

define("FAILED" , -1);

function saveUserSuccess__FAKE($email, $param) {

    return 42;
}

function saveUserFail__FAKE($email, $param) {

    return FAILED;
}

function saveUser($email, $param) {

    if(!isEmailValid_YES__FAKE($email)) {
        //Email not valid
        return FAILED;
    }

    if(isEmailAlreadyInDatabase__FAKE($email)) {
        //Email is in DB
        return FAILED;
    }

    $newUserID = saveUserToDB_SUCCESS__FAKE($email, $param);

    if($newUserID === null) {
        //Something went wrong?
        return FAILED;
    }

    return $newUserID;
}


