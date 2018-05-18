<?php

include_once "../constants/routeConstants.php";
include_once '../utils/sessionUtils.php';
include_once '../database/routeUtils.php';

loginRequired();


$distance= getDataFromPOST('distance');
$name = getDataFromPOST('routeName');
$mode = getDataFromPOST('mode');
$team = getDataFromPOST('team');
$origin = getDataFromPOST('origin');
$destination = getDataFromPOST('destination');
$start = addressToLatLong($origin);
$end = addressToLatLong($destination);
$startLatitude = $start[0];
$startLongitude = $start[1];
$endLatitude = $end[0];
$endLongitude = $end[1];

$userId = getActiveUserID();

echo $distance." ".$name." ".$mode." ".$team." ".$origin." ".$destination." ".$userId."<br>";
echo $startLatitude." ".$startLongitude." ".$endLatitude." ".$endLongitude."<br>";

if (!nullCheck(array($distance, $name, $mode, $origin, $destination))) {
    redirectToHomePageWithMessage(NOT_ENOUGH_DATA);
    return;
}

switch ($mode) {
    case PRIVATE_MODE:
        saveRoute($userId, $name, $distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    case TEAM_MODE:
        if ($team === null) {
            redirectToNewRoutePageWithMessage(TEAM_REQUIRED);
            return;
        }

        loginRequired(ADMIN_ROLE);
        saveRoute($userId, $name ,$distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);

        //TODO assign Team to Route and check if team exists

        break;

    case PUBLIC_MODE:
        loginRequired(ADMIN_ROLE);
        saveRoute($userId, $name ,$distance, $mode,
            $startLatitude, $startLongitude, $endLatitude, $endLongitude);
        break;

    default:
        break;
}
$conn = createConnectionFromConfigFileCredentials();
$sql2 = "SELECT * FROM w2final.Route WHERE user_fk = '$userId' AND startLatitude = '$startLatitude' AND startLongitude = '$startLongitude' AND endLatitude = '$endLatitude' AND endLongitude = '$endLongitude'";
$result2 = $conn->query($sql2);
$new = 0;
while ($row = $result2->fetch_assoc()) {
    $new = $row['id'];
}
$sql = "UPDATE w2final.User SET activeRoute_fk = '$new' WHERE id = 1";
$conn->query($sql);

//redirectToHomePageWithMessage(ROUTE_SUCCESSFULLY_SAVED,$routeID);


function getDataFromPOST($key) {
    if (isset($_POST[$key]) and $_POST[$key] !== "") {
        return $_POST[$key];
    } else {
        return null;
    }
}

function redirectToHomePageWithMessage($status,$routeID) {
    $query = array(
      'status' => $status,
      'routeID' => $routeID
    );
    $query = http_build_query($query);
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/homePage.php?status=' . $status);
}

function redirectToNewRoutePageWithMessage($status) {
    // TODO prevent input data loss -> send back in get if saving failed
    header('location: ../templates/newRoutePage.php?status=' . $status);
}

function nullCheck($array) {
    foreach ($array as $item) {
        if ($item === null) {
            return false;
        }
    }
    return true;
}

function addressToLatLong($dlocation){
    $address = str_replace(',','',$dlocation);
    $prepAddr = str_replace(' ','+',$address);
    //$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
    $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=true_or_false&key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4');
    $output= json_decode($geocode);
    $latlon[0] = $output->results[0]->geometry->location->lat;
    $latlon[1] = $output->results[0]->geometry->location->lng;
    return $latlon;
}











