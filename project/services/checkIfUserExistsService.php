<?php

include_once "../database/userUtils.php";

function checkIfUserExists($userID) {

    if ($userID === null) {
        return false;
    }

    $user = getUserFromUserId($userID);

    return $user !== null;

}