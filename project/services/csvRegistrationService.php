<?php

include_once "../services/saveUserService.php";
include_once "../security/randomPassword.php";

function processCsvFileAndSaveUsers__FAKE($csv) {

    return array(
        'succ@ess.sk' => '12345',
        'fa@il.sk' => null
    );
}


function processCsvFileAndSaveUsers($csv) {
// use this function to save every user saveUser(), check if return is not === FAILED, if not, we can say
//that user is in DB

    $userArray = handleFile($csv);

    //for every user
    $email = null;
    $params = null;
    $userRandomPassword = createRandomPassword__FAKE($params);
    $saveSuccessful = saveUserSuccess__FAKE($email, $params);

    if ($saveSuccessful) {
        //add to array his email and his set password
    } else {
        //add to array but set password to null;
    }
    //for END


}

function handleFile($file) {
    $fileContents = file_get_contents($file["tmp_name"]);
    $resultsMatrix = array();

    if (!$fileContents) {
        return null;
    }

    $firstLine = explode(";", $fileContents);

    for ($i = 0; $i < sizeof($firstLine) - 1; $i++) {

        $lineElements = explode(",", $firstLine[$i]);

        array_push($resultsMatrix, $lineElements);
    }

    return $resultsMatrix;
}



