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
    $results = processCsvFileAndSaveUsers__FAKE($csv);
    $table = createMassRegisterResultsTable($results);
    sendMassEmailsToSuccessfulUsers($results["successful"]);

    echo $table;

// file NOT uploaded
} else {

    echo "RIP";
}

//Create table from $saveResult somehow and get it on result site


// methods
//TODO  replace with table utility in later commit
function createMassRegisterResultsTable($arrayOfUserData) {
    $table = "<table>";

    foreach ($arrayOfUserData["failed"] as $user) {
        $table .= assembleTableRow($user["email"], getVerboseError($user["FAILURE_REASON"]));
    }

    foreach ($arrayOfUserData["successful"] as $user) {
        $table .= assembleTableRow($user["email"], "Successfully created");
    }

    $table .= "</table>";

    return $table;
}

function assembleTableRow($userEmail, $userStatus) {
    $row = "";
    $row .= "<tr>";

    $row .= "<td>";
    $row .= $userEmail;
    $row .= "</td>";

    $row .= "<td>";
    $row .= $userStatus;
    $row .= "</td>";

    $row .= "</tr> \n";
    return $row;
}

function getVerboseError($error) {
    switch ($error) {
        case ERROR_EMAIL_INVALID:
            return "Invalid email given";

        case ERROR_EMAIL_TAKEN:
            return "Email is already taken";
            
        default:
            return "Unknown error";
    }
}

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



