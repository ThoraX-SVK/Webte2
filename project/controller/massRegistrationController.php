<?php

include_once "../utils/sessionUtils.php";
include_once "../services/csvRegistrationService.php";

//get .csv file somehow, from POST?
$csv = null;

//check if in session there is admin logged in
if(!isUserAdmin_YES__FAKE()) {
    //user not ADMIN, print some error
}

$saveResult = processCsvFileAndSaveUsers__FAKE($csv);

//Create table from $saveResult somehow and get it on result site