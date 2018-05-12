<?php

include_once "../utils/sessionUtils.php";
include_once "../services/csvRegistrationService.php";
include_once "../services/sendEmailService.php";

//get .csv file somehow, from POST?
$csv = null;

//check if in session there is admin logged in
if(!isUserAdmin_YES__FAKE()) {
    //user not ADMIN, print some error
}

$saveResult = processCsvFileAndSaveUsers__FAKE($csv);

//For each user from result...

    //get this from array
    $userPassword = null;
    $userEmail = null;

    if($userPassword != null) {
        //send him email with his set password

        //TODO: Maybe move this email body construct functionality to utils?
        $emailBody = 'Your pass: ' . $userPassword . '   Please login with it bla bla bla.';
        sendEmail__FAKE($userEmail,$emailBody);
    }


//Create table from $saveResult somehow and get it on result site