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
include_once "../services/printRouteLastRunsTableService.php";
include_once "../constants/routeConstants.php";
include_once "../database/routeUtils.php";

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
    <meta charset="UTF-8">
    <title>Route</title>
</head>

<body>
<?php

echo getMenu();

?>

<header>
    <h1>All routes</h1>
</header>

<div class="content">

    <?php

    echo getLastRunsTable($routeID);
    printRouteDescription($routeID);
    ?>

</div>

</body>
</html>

<?php

function printRouteDescription($routeID) {
    $desc = getRouteFullDescription__FAKE($routeID);

    echo $desc["name"];
    echo $desc["totalDistance"];
    echo $desc["mode"];
    echo $desc["startLatitude"];
    echo $desc["startLongitude"];
    echo $desc["endLatitude"];
    echo $desc["endLongitude"];
}

?>

