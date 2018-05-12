<?php

include_once '../services/loginCheckService.php';
include_once '../utils/sessionUtils.php';

/**
 * This php code, will handle login request
 * We have to decide, what will come in $POST
 */
session_start();

/* This should be filled from POST request*/
if (isset($_POST["email"]) and isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
} else {
    redirectToLoginWithErrorMessage($email);
}


/**
 * Firstly we made call to loginCheckService.php
 *
 */
if(checkIfLoginCorrect($email, $password)) {

    /**
     * Create session here, probably from email?
     * Also resolve if ADMIN or USER
     */
    $userID = getUserIdFromEmail__FAKE($email);
    $userRole = getUserRoleFromUserId__FAKE($userID);
    createUserSession($userID, $email, $userRole["role"]);

    /**
     * Redirect to home page
     */
    header('location: ../templates/homePage.php');
}

/**
 *  Redirect to login.php with error message.
 */
redirectToLoginWithErrorMessage($email);

function redirectToLoginWithErrorMessage($email) {
    header('location: ../templates/login.php?status=INVALID&email=' . $email);
}

