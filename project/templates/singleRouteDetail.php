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
include_once "../services/checkRouteVisibilityService.php";

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

// check route visibility to user
if (!isRouteVisibleToUser(getActiveUserID(), $routeID)) {
    header("location: ../templates/allRoutes.php");
    return;
}

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
        echo createProgressBar($routeID);
        ?>
    </div>


    <div class="wrap-inline">

    <div id="map" style="border: 1px solid black"></div>
    <div class="route-description">
        <h2>Route Description</h2>
    <?php
        $array = getAlltDescription($routeID);
        echo "<h3>Name : ".$array["name"]."</h3>";
        echo "<h3>Distance : ".$array["totalDistance"] . "km"."</h3>";
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
<script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 48.12, lng: 25.12}
        });
        directionsDisplay.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
            origin:
            <?php
                $array = getAlltDescription($routeID);
                echo "{lat:".$array["startLatitude"].", lng:".$array["startLongitude"]."}";

            ?>,
            destination:
            <?php
            $array = getAlltDescription($routeID);
            echo "{lat:".$array["endLatitude"].", lng:".$array["endLongitude"]."}";
            ?>,
            travelMode: 'WALKING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4&libraries=places&callback=initMap"
        async defer></script>
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


