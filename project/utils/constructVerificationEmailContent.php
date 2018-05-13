<?php

include_once "../security/EmailVerificationHash.php";

function constructActivationEmailBody__FAKE($email, $userID) {

    return 'Testing purposes, this should be activation text and link';
}

function constructActivationEmailBody($email, $userID) {

    $verificationHash = computeEmailVerificationHash__FAKE($email, $userID);

    if(saveVerificationHash__FAKE($verificationHash, $userID)) {

        $emailBody = null;
        $emailBody = "Pre aktiváciu účtu registrovaného na email " . $email . "kliknite prosím na nasludujúci odkaz: " .
            "[link]/" . $verificationHash;

        return $emailBody;
    }

    return null;
}

