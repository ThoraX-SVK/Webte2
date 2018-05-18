<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Home</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 600px;
            width: 600px;
        }
        /* Optional: Makes the sample page fill the window. */
        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 40px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #origin-input,
        #destination-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 200px;
        }

        #origin-input:focus,
        #destination-input:focus {
            border-color: #4d90fe;
        }

    </style>
</head>

<body>
<?php
include_once "../template_utils/menuGenerator.php";

loginRequired();
echo getMenu();
showMessage();
?>


<header>
    <h1>Home Page</h1>
</header>


<div class="content-home">

    <?php
    include_once "../utils/sessionUtils.php";
    include_once "../database/userUtils.php";

    $userID = getActiveUserID();
    if (findUsersActiveRoute($userID) == null) {
        echo 'You have no active route yet. You can either select one of <a href="allRoutes.php"><em><strong> available routes</strong></em></a> or <a href="newRoutePage.php"><em><strong> create a new one</strong></em></a>.';
        exit(1);
    }
    ?>

    <div id="rightHolder">
        <div id="homeStats">
            <?php
            showRouteStats();
            ?>

        </div>
        <div id="runFormHolder">
            <form action="../controller/newRunController.php" method="POST">
                <br><br><span> Distance </span>
                <input type="text" name="distanceTraveled" required>
                <br><br><span> Date </span>
                <input type="date" name="dateOfRun">
                <br><br><span> Time of start </span>
                <input type="time" name="startAtTime">
                <br><br><span> Time of end </span>
                <input type="time" name="finishAtTime">

                <br><br><span> Start latitude </span>
                <input type="number" step="0.00001" name="startLatitude">
                <br><br><span> Start longitude </span>
                <input type="number" step="0.00001" name="startLongitude">

                <br><br><span> End latitude </span>
                <input type="number" step="0.00001" name="endLatitude">
                <br><br><span> End longitude </span>

                <input type="number" step="0.00001" name="endLongitude">
                <br><br><span> Rating </span>
                <input type="number" step="1" min="0" max="5" name="rating">
                <br><br><span> Note </span>
                <input type="text" name="note">

                <br><br><input type="submit" value="Submit">
            </form>
        </div>
    </div>

    <?php

    include_once "../constants/globallyUsedConstants.php";
    include_once '../constants/messageConstants.php';
    include_once '../constants/routeConstants.php';

    function showRouteStats() {
        include_once "../database/routeUtils.php";

        $userID = getActiveUserID();
        $routeID = findUsersActiveRoute($userID);
        $array = getRouteShortDescription($routeID);
        //print_r($array);
        echo $array["name"];
        echo "<br>";

        echo $array["totalDistance"] . "km";
    }

    function showMessage() {
        $message = getInfoMessage();
        if ($message != null) {
            echo $message;
            echo "</div>";
        }
    }

    function getInfoMessage() {

        if (isset($_GET["status"])) {

            $status = $_GET["status"];

            switch ($status) {
                case RUN_SUCCESSFULLY_SAVED:
                    return '<div class="success-message-wide">Your run has been successfully saved';
                case RUN_SAVING_FAILED:
                    return '<div class="error-message-wide">There has been an error and your run has NOT been saved';
            }
        }

        return null;
    }

    ?>

    <div id="map"></div>

    <?php
    include_once '../services/progressBarService.php';
    include_once "../database/routeUtils.php";

    $userID = getActiveUserID();
    $routeID = findUsersActiveRoute($userID);

    echo createProgressBar($routeID);
    ?>

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
            include_once "../database/routeUtils.php";

            $userID = getActiveUserID();
            $routeID = findUsersActiveRoute($userID);
            $array = getAlltDescription($routeID);
            echo "{lat:".$array["startLatitude"].", lng:".$array["startLongitude"]."}";

            ?>,
            destination:
            <?php
            include_once "../database/routeUtils.php";

            $userID = getActiveUserID();
            $routeID = findUsersActiveRoute($userID);
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