<?php

include_once "../database/routeUtils.php";

function createProgressBar__FAKE($routeID) {
    return createHTMLProgressBarString(42 , 42, 100);
}

function createHTMLProgressBarString($filledToPercent, $done, $total) {

    $progressBar = "";
    $progressBar .= '<div class="progress-bar-wrapper"><p id="middle">' . $done . '/'. $total ."</p>\n";
    $progressBar .= '<div class="progress-bar" style="width:' .  $filledToPercent . '%">'. '</div> ' . "\n";
    $progressBar .= '</div>' . "\n";

//    print_r($progressBar);

    return $progressBar;
}

function createProgressBar($routeID) {

    $calculations = calculateRouteRemainingAndDoneDistance($routeID);

    if($calculations['totalDistance'] === null) {
        //No track found
        return null;
    }

    if($calculations['done'] !== null) {
        $percentToFill = floor(($calculations['done'] / $calculations['totalDistance'])*100);
    } else {
        $percentToFill = 0;
    }

    if($percentToFill > 100) {
        $percentToFill = 100;
    }

    return createHTMLProgressBarString($percentToFill, $calculations['done'], $calculations['totalDistance']);
}

function createTeamProgressBar__FAKE() {

    $progressBar = "";
    $progressBar .= '<div class="progress-bar-wrapper">' . "\n";
    $progressBar .= '<div class="progress-bar color1" style="width:10%"></div>' . "\n";
    $progressBar .= '<div class="progress-bar color2" style="width:25%"></div>' . "\n";
    $progressBar .= '<div class="progress-bar color3" style="width:20%"></div>' . "\n";
    $progressBar .= '<div class="progress-bar color4" style="width:30%"></div>' . "\n";
    $progressBar .= '</div>' . "\n";

    return $progressBar;
}

function createTeamProgressBar($routeID) {

    $calculations = calculateRouteRemainingAndDoneDistance($routeID);
    $contributors = getRouteContributors($routeID);

    if($calculations['totalDistance'] === null) {
        //No track found
        return null;
    }

    $progressBar = "";
    $progressBar .= '<div class="progress-bar-wrapper">' . "\n";

    $index = 1;
    foreach ($contributors as $user) {
        $userContributed = $user['userContribution'];
        $percentToFill = floor(($userContributed / $calculations['totalDistance'])*100);
        $progressBar .= '<div class="progress-bar color' . $index .'" style="width:' .  $percentToFill . '%">' . $user['email'] . '</div>' . "\n";
        $index++;

        if($index === 11) {
            $index = 1;
        }
    }

    $progressBar .= '</div>' . "\n";

    return $progressBar;
}