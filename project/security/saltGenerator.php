<?php

function generateNewSalt__FAKE() {
    return 'salt';
}

function generateSalt() {
    return sha1(openssl_random_pseudo_bytes(64));
}
