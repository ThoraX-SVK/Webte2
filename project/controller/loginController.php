<?php

include_once '../services/loginCheckService.php';
include_once '../utils/sessionUtils.php';
include_once '../constants/loginConstants.php';

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
    redirectToLoginWithErrorMessage(INVALID_LOGIN, $email);
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
    $userID = getUserIdFromEmail($email);
    $userRole = getUserRoleFromUserId($userID);

    if (isUserActivated($userID)) {
        createUserSession($userID, $email, $userRole);

        // Redirect to home page
        header('location: ../templates/homePage.php');
    } else {

        redirectToLoginWithErrorMessage(ACCOUNT_INVACTIVE, $email);
    }

} else {
    /**
     *  Redirect to login.php with error message.
     */
    redirectToLoginWithErrorMessage(INVALID_LOGIN, $email);
}



function redirectToLoginWithErrorMessage($status, $email) {
    header('location: ../templates/login.php?status=' . $status . '&email=' . $email);
}

