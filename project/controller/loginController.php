<?php

include_once '../services/loginCheckService.php';

/**
 * This php code, will handle login request
 * We have to decide, what will come in $POST
 */

/* This should be filled from POST request*/
$email = "fake@fake.sk";
$password = "12345";

/**
 * Firstly we made call to loginCheckService.php
 *
 */
if(CheckLoginAlwaysTrue__FAKE($email, $password)) {

    /**
     * Create session here, probably from email?
     * Also resolve if ADMIN or USER
     */

    /**
     * Redirect to home page
     */
}

/**
 *  Redirect to login.php with error message.
 */
