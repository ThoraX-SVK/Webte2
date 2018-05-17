<!--//TODO: This should display single routePage.php-->
<!---->
<!--//TODO: Get data from _GET (routeID) in PHP-->
<!--//TODO: Check if user has visibility on that route-->
<!--//TODO: If not throw error and move him back to AllRoues-->
<!---->
<!---->
<!--//TODO: Call to singleRouteDetail service for all data to print-->
<!--    Maps            ???-->
<!--    Info            printLastRunsTable(routeID)-->
<!--    Logs            printFullDescriptionTable(routeID)-->
<!--    ProgressBar     createProgressBar(routeID)-->

<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";
include_once "../services/progressBarService.php";
include_once "../services/singleRouteServices.php";

loginRequired();

if (isset($_GET["routeID"])) {
    $routeID = $_GET["routeID"];
} else {
    $routeID = null;
}

if ($routeID === null) {
    header("location: ../templates/allRoutes.php");
    return;
}


$userID = getActiveUserID();

//TODO check user route visibility !!!

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/allRoutesTableStyle.css">
    <link rel="stylesheet" type="text/css" href="../static/singleRouteStyle.css">
    <meta charset="UTF-8">
    <title>Route</title>
</head>

<body>
<?php
echo getMenu();
?>

<header>
    <h1>Route Details</h1>
</header>

<div class="content-route">
    <div class="progress-bar-route">
        <?php
        echo createProgressBar__FAKE($routeID);
        ?>
    </div>


    <div class="wrap-inline">

    <div id="map" style="border: 1px solid black"></div>
    <div class="route-description">
        <h2>Route Description</h2>
    <?php
        printRouteDescription($routeID);
    ?>
    </div>

    </div>

    <div class="route-last-runs">
        <h2>Latest Contributors</h2>
        <?php
        echo getLastRunsTable($routeID);
        ?>
    </div>




</div>

</body>
</html>

<?php

function printRouteDescription($routeID) {
    $desc = getFullRouteDescription($routeID);

    echo $desc["name"] . "<br/> \n";
    echo $desc["totalDistance"] . "<br/> \n";
    echo $desc["activeContributorsCount"] . "<br/> \n";
    echo $desc["routeMode"] . "<br/> \n";
}

?>


