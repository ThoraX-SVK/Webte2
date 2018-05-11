<?php

include_once "../services/saveUserService.php";
include_once "../utils/sendVerificationEmail.php";


//Receive data from POST
$email = "e@e.sk";
$param = "more parameters placeholder";

/**
 * Call UserSaveService with all params from post
 */

if(saveUserSuccess__FAKE($email, $param) === FAILED) {
    //User saving failed, RIP I guess?
}

if(sendActivationEmail__FAKE($email, $newUserID)) {
    //Redirect to checkYourEmail.php
} else {
    //print some kind of error
}