<?php

include_once "../utils/sessionUtils.php";


function getMenu() {

    $menu = "";
    $menu .= '<div class="topnav">' . "\n";
    $menu .= '<a href="homePage.php">Home</a>' . "\n";
    $menu .= '<a href="allRoutes.php">Routes</a>' . "\n";
    $menu .= '<a href="newsPage.php">News</a>' . "\n";
    $menu .= '<a href="userStatsPage.php">My Stats</a>' . "\n";
    $menu .= '<a href="titlePage.php">About</a>' . "\n";
    $menu .= '<div class="topnav-right">';

    // only show when user is admin
    if (isUserAdmin()) {

        $menu .= '<a href="massRegisterPage.php">Mass register from CSV file</a>' . "\n";
        $menu .= '<a href="addNewsPage.php">Add News</a>' . "\n";
        $menu .= '<a href="allUsersStatsPage.php">All Users Stats</a>' . "\n";
        $menu .= '<a href="allTeams.php">All teams</a>' . "\n";

    }
    $menu .= '<a href="../controller/signOutController.php">Sign out</a>' . "\n";
    $menu .= '</div>';
    $menu .= '</div>';

    return $menu;
}