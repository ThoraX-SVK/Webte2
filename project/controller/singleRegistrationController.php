<?php

include_once "../services/saveUserService.php";
include_once "../utils/constructVerificationEmailContent.php";
include_once "../services/sendEmailService.php";


//Receive data from POST
$email = "e@e.sk";
$param = "more parameters placeholder";

/**
 * Call UserSaveService with all params from post
 */

$newUserID = saveUserSuccess__FAKE($email, $param);

if($newUserID === FAILED) {
    //User saving failed, RIP I guess?
}

$emailBody = constructActivationEmailBody__FAKE($email, $newUserID);

if($emailBody == null) {
    //something went wrong
}

sendEmail__FAKE($email,$emailBody);
