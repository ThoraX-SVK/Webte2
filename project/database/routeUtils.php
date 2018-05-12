<?php

include_once '../database/createConnection.php';

function getRouteInfoForMapAPI__FAKE($routeID) {

    //TODO: Might be totally different
    return array(
        'latStart' => '42',
        'lngStart' => '42',
        'latEnd' => '43',
        'lngEnd' => '43'
    );
}

function getRouteInfoForMapAPI($routeID) {

    //TODO: Look to DB and return some data
}

function getRouteShortDescription__FAKE($routeID) {

    return array(
        'name' => 'Za mesiac na mesiac',
        'totalDistance' => 384000
    );
}

function getRouteShortDescription($routeID) {

    //TODO: Look to DB and construct short description
}

function getRouteFullDescription__FAKE($routeID) {

    return array(
        'name' => 'Za mesiac na mesiac',
        'totalDistance' => 384000,
        'more info' => 'This is full description btw!'
    );
}

function getRouteFullDescription($routeID) {

    //TODO: Look to DB and construct full description
}

function getRouteContributors__FAKE($routeId) {

   return array(
       'first@one.sk' => 100,
       'second@two.sk' => 50,
       'last @lats.sk' => 10
   );
}

function getRouteContributors($routeId) {

    //TODO: Look in DB and onstruct array of users and their km

}

function saveRoute($creatingUserID, $totalDistance, $mode) {

    $conn = createConnectionFromConfigFileCredentials();

    $stmn = $conn->prepare("INSERT w2final.Route VALUES (DEFAULT, ?, ?, ?)");
    $stmn->bind_param('iii',$creatingUserID,$totalDistance, $mode);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}


