<?php

function isEmailValid_YES__FAKE($email) {
    return true;
}

function isEmailValid_NO__FAKE($email) {
    return false;
}

function isEmailValid($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}