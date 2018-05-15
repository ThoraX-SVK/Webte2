<?php

include_once "../database/routeUtils.php";

function createProgressBar__FAKE($routeID) {
    $progressBar = "";
    $progressBar .= '<div class="progress-bar-wrapper">' . "\n";
    $progressBar .= '<div class="progress-bar" style="width: 50%"></div> ' . "\n";
    $progressBar .= '</div>' . "\n";


    return $progressBar;

    //return fake representation of progress bar
}

function createProgressBar($routeID) {

    $contributors = getRouteContributors__FAKE($routeID);

    //TODO: Construct progress bar
}

