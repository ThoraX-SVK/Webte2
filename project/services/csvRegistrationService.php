<?php

include_once "../services/saveUserService.php";

function processCsvFileAndSaveUsers__FAKE($csv) {

    return array(
        'succ@ess.sk' => true,
        'fa@il.sk' => false
    );
}


function processCsvFileAndSaveUsers($csv) {
// use this function to save every user saveUser(), check if return is not === FAILED, if not, we can say
//that user is in DB

    //for every user
    $email = null;
    $params = null;
    $saveResult = saveUser($email, $params);
    //do something with save result

}


