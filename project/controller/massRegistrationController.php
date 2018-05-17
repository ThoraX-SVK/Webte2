<?php

include_once "../utils/sessionUtils.php";
include_once "../utils/EmailValidator.php";
include_once "../services/csvRegistrationService.php";
include_once "../services/sendEmailService.php";
include_once "../utils/constructVerificationEmailContent.php";
include_once "../constants/registerConstants.php";
include_once "../constants/globallyUsedConstants.php";
include_once "../template_utils/tableGenerator.php";


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
    $table = createMassRegisterResultsTable($results);
    sendMassEmailsToSuccessfulUsers($results["successful"]);

    $resultsToPrintInTemplate = array ( "table" => $table );

// file NOT uploaded
} else {

    $resultsToPrintInTemplate = array ( "error" => "File not uploaded correctly!" );
}

echo "AJAX RESPONSE:\n";
echo "SUCCESSFUL:\n <br/>";
foreach ($results["successful"] as $succ) {
    foreach ($succ as $s) {
        echo print_r($s) . " <br/>";
    }
    echo "\n ------------------------------------------<br/><br/>";
}

echo "FAILED:\n <br/>";
foreach ($results["failed"] as $fa) {
    foreach ($fa as $f) {
        echo print_r($f) . " <br/>";
    }
    echo "\n ------------------------------------------<br/><br/>";
}

// echo to response (from AJAX call)
// do not remove
//echo json_encode($resultsToPrintInTemplate);


// methods
function createMassRegisterResultsTable($arrayOfUserData) {

    $header = array("User email", "Save status");
    $content = getUserMassRegisterTableContent(array_merge($arrayOfUserData["successful"], $arrayOfUserData["failed"]));

    $table = assembleTable($header, $content);

    return $table;
}


function getUserMassRegisterTableContent($arrayOfUserData) {
    $content = array();

    foreach ($arrayOfUserData as $userData) {

        if (array_key_exists("FAILURE_REASON", $userData)) {
            $status = getVerboseError($userData["FAILURE_REASON"]);
        } else {
            $status = "Successfully created";
        }

        array_push($content, array($userData["email"], $status));
    }

    return $content;
}

function getVerboseError($error) {
    switch ($error) {
        case ERROR_EMAIL_INVALID:
            return "Invalid email given";

        case ERROR_EMAIL_TAKEN:
            return "Email is already taken";

        default:
            return $error;
    }
}

function sendMassEmailsToSuccessfulUsers($arrayOfUserData) {
    foreach ($arrayOfUserData as $userData) {
        $email = $userData["email"];
        $password = $userData["password"];

        if ($email != null and isEmailValid($email) and $password != null) {
            $emailAttrs = constructActivationEmail($email, getUserIdFromEmail__FAKE($email), $password);
            sendEmail__FAKE($email, $emailAttrs["subject"], $emailAttrs["body"], $emailAttrs["from"]);
        }

    }
}

function getFileFromPOST() {

    if (isset($_FILES["file"]) and $_FILES["file"]["error"] <= 0) {

        return $_FILES["file"];

    } else {

        return null;
    }

}

function redirectToRegisterWithMessage($status) {
    header('location: ../templates/massRegisterPage.php?status=' . $status);
}



