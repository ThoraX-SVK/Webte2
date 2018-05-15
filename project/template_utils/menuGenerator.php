<?php

include_once "../utils/sessionUtils.php";


function getMenu() {

    $menu = "";
    $menu .= '<div class="topnav">' . "\n";
    $menu .= '<a href="about.php">About</a>' . "\n";
    $menu .= '<a href="login.php">Login</a>' . "\n";
    $menu .= '<a href="homePage.php">Home</a>' . "\n";
    $menu .= '<a href="routesPage.php">Routes</a>' . "\n";

    // only show when user is admin
    if (isUserAdmin_YES__FAKE()) {
        echo '<div class="topnav-right">';
        echo '<a href="massRegisterPage.php">Mass register from CSV file</a>' . "\n";
        echo '</div>';
    }

    $menu .= '</div>';

    return $menu;
}