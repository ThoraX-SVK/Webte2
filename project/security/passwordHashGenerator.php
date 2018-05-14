<?php

function computePasswordHash__FAKE($salt, $password) {

    return 'hash';
}

function computePasswordHash($salt, $password) {

    //TODO: SHA-256, some iterations...

    //TODO: First iteration, might do better security in future;
    $toHash = $salt . $password;

    return hash("sha256", $toHash);
}
