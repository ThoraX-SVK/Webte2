<?php

include_once "../utils/sessionUtils.php";


function getMenu() {

    $menu = "";
    $menu .= '<div class="topnav">' . "\n";
    $menu .= '<a href="titlePage.php">About</a>' . "\n";
    $menu .= '<a href="login.php">Login</a>' . "\n";
    $menu .= '<a href="homePage.php">Home</a>' . "\n";
    $menu .= '<a href="allRoutes.php">Routes</a>' . "\n";

    // only show when user is admin
    if (isUserAdmin_YES__FAKE()) {
        $menu .= '<div class="topnav-right">';
        $menu .= '<a href="massRegisterPage.php">Mass register from CSV file</a>' . "\n";
        $menu .= '</div>';
    }

    $menu .= '</div>';

    return $menu;
}