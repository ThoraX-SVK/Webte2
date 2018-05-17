<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/newTeamStyle.css">
    <meta charset="UTF-8">
    <title>Add new route</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";


echo getMenu();

?>

<header>
    <h1>
        Add New Route
    </h1>
</header>

<div class="content-home">
    <?php
    include_once "../services/printRouteModeSelectService.php";
    include_once "../services/printTeamsSelectService.php";
    include_once "../utils/sessionUtils.php";
    include_once  "../constants/routeConstants.php";

    loginRequired();

    // error message
    showMessage();
    ?>
    <h2 align="left">New route detail</h2>
    <div id="rightHolder">
        <div id="homeStats" style="margin-top: 100px;">

    <form action="../controller/newRouteController.php" method="post">

        <!--    fill from google map API i guess?    -->
        <input type="hidden" placeholder="" name="distance" value="100" required>
        <input type="hidden" placeholder="" name="startLatitude" value="42" required>
        <input type="hidden" placeholder="" name="startLongitude" value="17" required>
        <input type="hidden" placeholder="" name="endLatitude" value="43" required>
        <input type="hidden" placeholder="" name="endLongitude" value="17" required>

        <input type="text" placeholder="Route name" name="routeName" required>

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



