<?php

include_once '../database/createConnection.php';

function saveRun__FAKE($userID, $userActiveRouteID,
                       $distanceTraveled,
                       $dateOfRun,
                       $startAtTime,$finishAtTime,
                       $startLatitude,$startLongitude,
                       $endLatitude,$endLongitude,
                       $rating,
                       $note) {

    return true;
}

function saveRun($userID, $userActiveRouteID,
                 $distanceTraveled,
                 $dateOfRun,
                 $startAtTime,$finishAtTime,
                 $startLatitude,$startLongitude,
                 $endLatitude,$endLongitude,
                 $rating,
                 $note) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.Run VALUES (DEFAULT , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmn->bind_param("isssddddisii",
        $distanceTraveled,
        $dateOfRun,
        $startAtTime, $finishAtTime,
        $startLatitude, $startLongitude,
        $endLatitude, $endLongitude,
        $rating,
        $note,
        $userActiveRouteID,
        $userID
        );

    $isExecuted = $stmn->execute();
    $stmn->close();
    $conn->close();

    return $isExecuted;
}