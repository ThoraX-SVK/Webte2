<?php

include_once "../utils/sessionUtils.php";
include_once "../utils/EmailValidator.php";
include_once "../services/csvRegistrationService.php";
include_once "../services/sendEmailService.php";
include_once "../utils/constructVerificationEmailContent.php";
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
if ($csv !== null) {
    $results = processCsvFileAndSaveUsers($csv);
    sendMassEmailsToSuccessfulUsers($results["successful"]);

// file NOT uploaded
} else {

    echo "RIP";
}

//Create table from $saveResult somehow and get it on result site


// methods
function sendMassEmailsToSuccessfulUsers($arrayOfUserData) {
    foreach ($arrayOfUserData as $userData) {
        $email = $userData["email"];
        $password = $userData["password"];

        if ($email != null and isEmailValid($email) and $password != null) {
            $emailAttrs = constructActivationEmail($email, getUserIdFromEmail($email), $password);
            sendEmail($email, $emailAttrs["subject"], $emailAttrs["body"], $emailAttrs["from"]);
        }

    }
}

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



