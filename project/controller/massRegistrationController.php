<?php

include_once "../utils/sessionUtils.php";
include_once "../services/csvRegistrationService.php";
include_once "../services/sendEmailService.php";
include_once "../constants/registerConstants.php";


//check if in session there is admin logged in
if (!isUserAdmin_YES__FAKE()) {
    //user not ADMIN, print error
    redirectToRegisterWithMessage(ERROR_USER_NOT_ADMIN);
    return;
}

//get .csv file from POST FILES
$csv = getFileFromPOST();

// file successfully gotten
if ($csv != null) {
    $results = processCsvFileAndSaveUsers($csv);
    //var_dump($results);

// file NOT uploaded
} else {

    echo "RIP";
}

//For each user from result...

//get this from array
$userPassword = null;
$userEmail = null;

if ($userPassword != null) {
    //send him email with his set password

    //TODO: Maybe move this email body construct functionality to utils?
    $emailBody = 'Your pass: ' . $userPassword . '   Please login with it bla bla bla.';
    sendEmail__FAKE($userEmail, $emailBody);
}


//Create table from $saveResult somehow and get it on result site


function getFileFromPOST() {

    $fileError = null;

    if (isset($_FILES["file"]) and $_FILES["file"]["error"] <= 0) {

        return $_FILES["file"];

    } else {

        return null;
    }

}

function redirectToRegisterWithMessage($status) {
    header('location: ../templates/massRegisterPage.php?status=' . $status);
}



