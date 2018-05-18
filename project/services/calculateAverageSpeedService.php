<?php

include_once "../database/userUtils.php";

/**
 * @param $startTime - 00:00:00 format
 * @param $endTime - 00:00:00 format
 * @param $distance - in km
 * @param int $precicion
 * @return float|int - returns average speed between given times
 */
function getAverageSpeedBetweenTimes($startTime, $endTime, $distance, $precicion = 2) {
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $timePassed = round(abs($endTime - $startTime) / 3600, $precicion);

    return getAverageSpeed($timePassed, $distance, $precicion);
}

function getAverageSpeedOfUser($userID) {
    $runs = getAllUsersRuns($userID);

    if ($runs === null) {
        return "No runs for this user.";
    }

    $sumOfSpeeds = 0;
    $divisor = 0;

    foreach ($runs as $run) {
        $averageRunSpeed = getAverageSpeedBetweenTimes($run["startAtTime"], $run["endAtTime"], $run["distance"], 5);

        // weed out the INF values (when user didnt input times or whatever)
        if (!is_numeric($averageRunSpeed) or $averageRunSpeed === INF) {
            continue;
        }

        $sumOfSpeeds += $averageRunSpeed;
        $divisor += 1;
    }

    return round($sumOfSpeeds / $divisor, 2);
}


/**
 * @param $timePassed
 * @param $distance
 * @param int $roundTo
 * @return float|int
 */
function getAverageSpeed($timePassed, $distance, $roundTo = 2) {
    return round($distance / $timePassed, $roundTo);
}