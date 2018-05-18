<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Add new route</title>
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
<div class="content-home">

    <?php
    include_once "../services/printRouteModeSelectService.php";
    include_once "../services/printTeamsSelectService.php";
    include_once "../utils/sessionUtils.php";
    include_once  "../constants/routeConstants.php";
    include_once  "../constants/globallyUsedConstants.php";

    loginRequired();

    // error message
    showMessage();
    ?>
    <div id="rightHolder">
        <div id="runFormHolder">
            <form action="../controller/newRouteController.php" method="post">
                <br><br><span> Route name: </span>
                <input type="text" class ="controls"name="routeName" required><br>
                <br><br><span>Origin location: </span>
                <input id="origin-input"name="origin" class ="controls" type="text" ><br>
                <br><br><span>Final location: </span>
                <input id="destination-input" name="destination" class ="controls" type="text"><br>
                <br><br><span> Distance(km): </span>
                <input type="text" class ="controls" id="distance" name="distance" required><br>
                <p id="origin-hide" hidden></p><br>
                <p id="destination-hide" hidden ></p><br>


                <br/>
                <?php
                echo getRouteModeSelect();
                ?>

                <br/>
                <?php
                echo getTeamsSelect();
                ?>
                <br/>

                <input type="submit" value="Save">
            </form>
        </div>
    </div>

    <div id="map"></div>
</div>
<script src="../static/newRouteScript.js"></script>
<script src="../static/pointToPointRouteScript.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4&libraries=places&callback=initMap"
        async defer></script>
</body>
</html>

<?php
function showMessage() {
    $message = getInfoMessage();
    if ($message != null) {
        echo "<div>";
        echo $message;
        echo "</div>";
    }
}

function getInfoMessage() {

    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case NOT_ENOUGH_DATA:
                return "Not enough POST data to save route";
            case TEAM_REQUIRED:
                return "Team has to be selected in this mode";
        }
    }

    return null;
}

?>



