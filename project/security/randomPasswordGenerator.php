<?php

function createRandomPassword__FAKE($passwordLength = null) {

    return 'password';
}

/**
 * Creates random string. If parameter $passwordLength is not defined
 * default value of 8 is used.
 *
 * @param null $passwordLength
 * @return bool|string
 *
 */
function createRandomPassword($passwordLength = null) {

    if($passwordLength === null) {
        $passwordLength = 8;
    }

    $hash = base64_encode(openssl_random_pseudo_bytes(32));
    return substr($hash,0,$passwordLength);
}

