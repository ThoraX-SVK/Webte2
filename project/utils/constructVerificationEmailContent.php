<?php

include_once "../security/EmailVerificationHash.php";

define("DEFAULT_FROM" , "noreply@run.sk");


function constructActivationEmailBody__FAKE($email, $userID) {

    return 'Testing purposes, this should be activation text and link';
}

function constructActivationEmailBody($email, $userID) {

    $verificationHash = computeEmailVerificationHash__FAKE($email, $userID);

    if(saveVerificationHash__FAKE($verificationHash, $userID)) {

        $emailBody = "Pre aktiváciu účtu registrovaného na email " . $email . "kliknite prosím na nasludujúci odkaz: " .
            "[link]/" . $verificationHash;

        return $emailBody;
    }

    return null;
}

function constructActivationEmail($email, $userID) {
    $emailBody = constructActivationEmailBody($email, $userID);
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

