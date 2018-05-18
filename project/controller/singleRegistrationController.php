<?php

include_once "../services/saveUserService.php";
include_once "../utils/constructVerificationEmailContent.php";
include_once "../utils/EmailValidator.php";
include_once "../utils/sessionUtils.php";
include_once "../services/sendEmailService.php";
include_once "../constants/registerConstants.php";
include_once "../constants/globallyUsedConstants.php";


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

$userData = createEmptyUser();

$userData['email'] = $email;
$userData['name'] = $name;
$userData['surname'] = $surname;
$userData['password'] = $password;
$userData['passwordConfirm'] = $passwordConfirm;

$saveResult = saveUser($userData);

// user saving failed
if ($saveResult["status"] === FAILED) {
    //User saving failed, RIP I guess?
    redirectToRegisterWithErrorMessage($saveResult["reason"]);

// user saving successful
} else {

//    $emailData = constructActivationEmail($email, $saveResult["userID"], $password);
//    if ($emailData != null and isEmailValid($email)) {
//        sendEmail($email, $emailData["subject"], $emailData["body"], $emailData["from"]);
//
//        redirectToRegistrationSuccess($email);
//    }

    // remove in case emails get implemented
    createUserSession($saveResult["userID"], $email, USER_ROLE);
    redirectToRegistrationSuccess($email);

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
