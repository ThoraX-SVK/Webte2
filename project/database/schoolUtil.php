<?php

include_once '../database/createConnection.php';

function getSchoolIDSaveIfNecessary($school, $addressID) {

    $schoolID = getSchoolID($school, $addressID);

    if($schoolID === null) {
        saveSchool($school, $addressID);
        $schoolID = getSchoolID($school, $addressID);
    }

    return $schoolID;
}

function getSchoolID($school, $addressID) {



    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.School WHERE name = ? AND address_fk = ?");
    $stmn->bind_param("si", $school,$addressID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function saveSchool($school, $addressID) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.School VALUES (DEFAULT , ? , ?)");
    $stmn->bind_param("si", $school,$addressID);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}




