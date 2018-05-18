<?php


/**
 * @param $startTime - 00:00:00 format
 * @param $endTime - 00:00:00 format
 * @param $distance - in km
 * @return float|int - returns average speed between given times
 */
function getAverageSpeedBetweenTimes($startTime, $endTime, $distance) {
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $timePassed = round(abs($endTime - $startTime) / 3600,2);

    return getAverageSpeed($timePassed, $distance);
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