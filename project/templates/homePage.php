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
session_start()
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
                <br><br><span> Date of run </span>
                <input type="date" class ="controls" name="dateOfRun">
                <br><br><span> Time of start </span>
                <input type="time" class ="controls" name="startAtTime">
                <br><br><span> Time of end </span>
                <input type="time" class ="controls" name="finishAtTime">
                <br><br><span> Start location</span>
                <input id="origin-input"name="origin" class ="controls" type="text" >
                <br><br><span> End location</span>
                <input id="destination-input" name="destination" class ="controls" type="text">
                <br><br><span> Distance(km): </span>
                <input type="text" class ="controls" id="distance" name="distance" readonly required>
                <br><br><span> Rating </span>
                <input type="number" class ="controls" step="1" min="0" max="5" name="rating">
                <br><br><span> Note </span>
                <input type="text" class ="controls" name="note">

                <p id="origin-hide" hidden></p><br>
                <p id="destination-hide" hidden ></p><br>

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
        //progressBar($routeID);
        echo $array["name"];
        echo "<br>";

        echo $array["totalDistance"] . "km";
        $_SESSION["routeID"] = $routeID;
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
<script src="../static/pointToPointRouteScript.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4&libraries=places&callback=initMap"
        async defer></script>
</body>
</html>