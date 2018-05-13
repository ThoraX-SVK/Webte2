<?php

include_once "../services/saveUserService.php";
include_once "../utils/constructVerificationEmailContent.php";
include_once "../services/sendEmailService.php";
include_once "../constants/registerConstants.php";


//Receive data from POST and validate
if (validatePostData() == FAILED) {
    redirectToRegisterWithErrorMessage(INVALID_POST);
    return;
}

$email = $_POST["email"];
$name = $_POST["name"];
$surname = $_POST["surname"];
$password = $_POST["password"];
$passwordConfirm = $_POST["password-confirm"];

/**
 * Call UserSaveService with all params from post
 */
$saveResult = saveUser($email, $name, $surname, $password, $passwordConfirm);

// user saving failed
if ($saveResult["status"] === FAILED) {
    //User saving failed, RIP I guess?
    redirectToRegisterWithErrorMessage($saveResult["reason"]);

// user saving successful
} else {

    $emailData = constructActivationEmail($email, $saveResult["userID"]);
    if ($emailData != null) {
        sendEmail($email, $emailData["subject"], $emailData["body"], $emailData["from"]);
        redirectToRegistrationSuccess($email);
    }

}


function validatePostData() {
    $isPostValid = isset($_POST["name"]) and isset($_POST["surname"]) and isset($_POST["email"]) and isset($_POST["password"]) and isset($_POST["password-confirm"]);

    if (!$isPostValid) {
        return FAILED;
    }

    return SUCCESS;
}

function redirectToRegisterWithErrorMessage($status) {
    header('location: ../templates/register.php?status=' . $status);
}

function redirectToRegistrationSuccess($email) {
    header('location: ../templates/checkYourEmail.php?email=' . $email);
}
