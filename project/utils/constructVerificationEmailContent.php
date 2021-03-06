<?php

include_once "../security/EmailVerificationHash.php";
include_once '../database/verificationUtils.php';

define("DEFAULT_FROM" , "noreply@run.sk");


function constructActivationEmailBody__FAKE($email, $userID) {

    return 'Testing purposes, this should be activation text and link';
}


/**
 *  Internally creates hash for user, saves it to DB. If save to DB
 *  was successful, it returns email body. Else returns NULL.
 *
 * @param $email
 * @param $userID
 * @return null|string
 */
function constructActivationEmailBody($email, $userID, $password = null) {

    $verificationHash = computeEmailVerificationHash();

    if(saveVerificationHash($verificationHash, $userID)) {

        if ($password === null) {
            $emailBody = "Pre aktiváciu účtu registrovaného na email " . $email . " s heslom " . $password . " kliknite prosím na nasludujúci odkaz: " .
                '<a href="http://147.175.98.166/project/controller/emailVerificationController.php?id=' . $userID . '&hash=' . $verificationHash . '">LINK</a>';
        } else {
            $emailBody = "Pre aktiváciu účtu registrovaného na email " . $email . " kliknite prosím na nasludujúci odkaz: " .
                '<a href="http://147.175.98.166/project/controller/emailVerificationController.php?id=' . $userID . '&hash=' . $verificationHash . '">LINK</a>';
        }


        return $emailBody;
    }

    return null;
}

function constructActivationEmail($email, $userID, $password) {
    $emailBody = constructActivationEmailBody($email, $userID, $password);
    $from = DEFAULT_FROM;
    $subject = "Aktivácia účtu";

    if ($emailBody == null) {
        return null;
    }

    return array (
        "email" => $email,
        "body" => $emailBody,
        "from" => $from,
        "subject" => $subject
    );

}

