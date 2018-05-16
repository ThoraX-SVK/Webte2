<?php

include_once "../database/routeUtils.php";

function createProgressBar__FAKE($routeID) {
    return createHTMLProgressBarString(42 , 42, 100);
}

function createHTMLProgressBarString($filledToPercent, $done, $total) {

    $progressBar = "";
    $progressBar .= '<div class="progress-bar-wrapper">' . "\n";
    $progressBar .= '<div class="progress-bar" style="width:' .  $filledToPercent . '%">'. $done . '/'. $total .'</div> ' . "\n";
    $progressBar .= '</div>' . "\n";

//    print_r($progressBar);

    return $progressBar;
}

function createProgressBar($routeID) {

    $calculations = calculateRouteRemainingAndDoneDistance($routeID);

    $percentToFill = floor(($calculations['done'] / $calculations['totalDistance'])*100);

    echo $percentToFill;

    if($percentToFill > 100) {
        $percentToFill = 100;
    }

    return createHTMLProgressBarString($percentToFill, $calculations['done'], $calculations['totalDistance']);
}