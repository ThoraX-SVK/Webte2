<?php

include_once "../security/EmailVerificationHash.php";

function sendActivationEmail__FAKE($email, $userID) {

    return true;
}

function sendActivationEmail($email, $userID) {

    $verificationHash = computeEmailVerificationHash__FAKE($email, $userID);

    if(saveVerificationHash($verificationHash, $userID)) {
        /**
         * Send email
         */

        return true;
    }

    return false;
}

