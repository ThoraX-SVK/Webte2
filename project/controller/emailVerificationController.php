<?php

include_once '../database/verificationUtils.php';
include_once '../database/userUtils.php';

$userID = null;
if(isset($_GET['id'])) {
    $userID = $_GET['id'];
}

$hash = null;
if(isset($_GET['hash'])) {
    $hash = $_GET['hash'];
}

if($userID === null || $hash === null) {
    //TODO: Redirect user to some error page
}

$hashFromDB = getVerificationHashForUserID($userID);

if($hashFromDB === null || $hashFromDB !== $hash) {
    //TODO: Redirect user to error page
}

activateUserAccount($userID);

//TODO: Maybe send some note that activation was successful?
header('location: ../templates/login.php');





