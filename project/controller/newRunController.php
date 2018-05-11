<?php

include_once "../utils/sessionUtils.php";
include_once "../database/userUtils.php";
include_once "../database/runUtils.php";

//new run, data from POST here

$distanceTraveled = 10;

$userID = getActiveUserID__FAKE();

$userActiveRouteID = findUsersActiveRoute__FAKE($userID);

// data is placeholder for all things that will go to this function, run ID will be there too,
// did not want to have there X params in template
$data = null;

saveRun__FAKE($data);
