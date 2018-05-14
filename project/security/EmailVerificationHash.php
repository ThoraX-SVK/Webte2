<?php

function computeEmailVerificationHash__FAKE() {

    return 'emailHash';
}

/**
 * Creates hash that will be included in email
 *
 * @return string
 */
function computeEmailVerificationHash() {
    return hash("sha256", createRandomPassword(40));
}


