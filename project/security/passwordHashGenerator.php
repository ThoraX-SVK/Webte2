<?php

function computePasswordHash__FAKE($salt, $password) {

    return 'hash';
}

function computePasswordHash($salt, $password) {
    
    $toHash = $salt . $password;
    return hash("sha256", $toHash);
}
