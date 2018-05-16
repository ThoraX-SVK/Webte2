<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Add new route</title>
</head>
<body>


<div class="main">
    <?php
    include_once "../services/printRouteModeSelectService.php";
    include_once "../services/printTeamsSelectService.php";
    include_once "../utils/sessionUtils.php";
    include_once  "../constants/routeConstants.php";

    loginRequired();

    // error message
    showMessage();
    ?>

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



