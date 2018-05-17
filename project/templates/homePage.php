<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Home</title>
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

    $userID = getActiveUserID__FAKE();
    if (findUsersActiveRoute__FAKE($userID) == null) {
        echo 'You have no active route yet. You can either select one of <a href="routes.php"><em><strong> available routes</strong></em></a> or <a href="createRoute.php"><em><strong> create a new one</strong></em></a>.';
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
                <br><br><span> Time of start </span>
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

                <br><br><span> Start location</span>
                <input id="origin"  type="text">
                <br><br><span> End location</span>
                <input id="destination" type="text">


                <br><br><span> Rating </span>
                <input type="number" step="1" min="0" max="5" name="rating">
                <br><br><span> Note </span>
                <input type="text" name="note">

                <br><br><input type="submit" value="Submit">
            </form>
        </div>
    </div>

    <?php

    include_once '../constants/messageConstants.php';
    include_once '../constants/routeConstants.php';

    function showRouteStats() {
        include_once "../database/routeUtils.php";


        $userID = getActiveUserID();
        $routeID = findUsersActiveRoute($userID);
        $array = getRouteShortDescription__FAKE($routeID);

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
                case ROUTE_SUCCESSFULLY_SAVED:
                    return '<div class="success-message-wide">Your new route has been saved';
            }
        }

        return null;
    }

    ?>
    <div id="map"></div>


    <?php
    include_once '../services/progressBarService.php';
    echo createProgressBar__FAKE(null);
    ?>

</div>

<script src="../static/pointToPointRouteScript.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4&libraries=places&callback=initMap"
        async defer></script>
</body>
</html>