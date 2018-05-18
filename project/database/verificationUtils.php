<?php

include_once '../database/createConnection.php';

function saveVerificationHash__FAKE($hash, $userID) {
    return true;
}

/**
 * Saves hash and userID to table, so it can be later checked
 * when he clicks on email with link.
 * Returns whether save was successful.
 * 
 * @param $hash
 * @param $userID
 * @return bool
 */
function saveVerificationHash($hash, $userID) {

//    if (checkIfUserHasVerificationHash($userID)) {
//        return false;
//    }

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT INTO w2final.VerificatonHash VALUES (DEFAULT, ?, ?)");
    $stmn->bind_param("si",$hash,$userID);
    
    $isDone = $stmn->execute();
    
    $stmn->close();
    $conn->close();
    
    return $isDone;
}

function getVerificationHashForUserID__FAKE($userID) {
    return 'emailHash';
}

function checkIfUserHasVerificationHash($userID) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.VerificatonHash WHERE user_fk = ?");
    $stmn->bind_param('i', $userID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return false;
    }

    return true;
}

/**
 *  Returns hash that was sent to user email to validate his account, or NULL
 *  when no such hash exists.
 * 
 * @param $userID
 * @return string|null
 */
function getVerificationHashForUserID($userID) {
    
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT hash FROM w2final.VerificatonHash WHERE user_fk = ?");
    $stmn->bind_param('i', $userID);
    $stmn->execute();
    
    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();
    
    if(mysqli_num_rows($result) === 0) {
        return null;
    }
    
    return $result->fetch_assoc()['hash'];
}
