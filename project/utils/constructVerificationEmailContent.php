<?php

include_once "../security/EmailVerificationHash.php";

function constructActivationEmailBody__FAKE($email, $userID) {

    return 'Testing purposes, this should be activation text and link';
}

function constructActivationEmailBody($email, $userID) {

    $verificationHash = computeEmailVerificationHash__FAKE($email, $userID);

    if(saveVerificationHash__FAKE($verificationHash, $userID)) {

        $emailBody = null;
        //construct email body here

        return $emailBody;
    }

    return null;
}

