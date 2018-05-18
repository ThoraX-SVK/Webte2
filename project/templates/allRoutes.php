<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/allRoutesTableStyle.css">
    <meta charset="UTF-8">
    <title>All Routes</title>

    <script>
        function showPublicRoutes() {
            if (document.getElementById("publicRoutes").style.display == "none") {
                document.getElementById("publicRoutesButton").value = "Show public routes";
                document.getElementById("publicRoutes").style.display = "block";
            }
            else {
                document.getElementById("publicRoutesButton").value = "Hide public routes";
                document.getElementById("publicRoutes").style.display = "none";
            }
        }

        function showPrivateRoutes() {
            if (document.getElementById("privateRoutes").style.display == "none") {
                document.getElementById("privateRoutesButton").value = "Show private routes";
                document.getElementById("privateRoutes").style.display = "block";
            }
            else {
                document.getElementById("privateRoutesButton").value = "Hide private routes";
                document.getElementById("privateRoutes").style.display = "none";
            }
        }

        function showTeamRoutes() {
            if (document.getElementById("teamRoutes").style.display == "none") {
                document.getElementById("teamRoutesButton").value = "Show team routes";
                document.getElementById("teamRoutes").style.display = "block";
            }
            else {
                document.getElementById("teamRoutesButton").value = "Hide team routes";
                document.getElementById("teamRoutes").style.display = "none";
            }
        }


    </script>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";

loginRequired();
echo getMenu();
showMessage();
?>


<header>
    <h1>All routes</h1>
</header>

<div class="content">
    <div id="routeButtonsHolder">
        <input type="button" onclick="showPublicRoutes()" value="Hide public routes" id="publicRoutesButton">
        <input type="button" onclick="showPrivateRoutes()" value="Hide private routes" id="privateRoutesButton">
        <input type="button" onclick="showTeamRoutes()" value="Hide team routes" id="teamRoutesButton">
    </div>

    <?php
    include_once "../services/printRoutesTableService.php";
    include_once "../constants/routeConstants.php";

    $tables = getRouteTables();

    ?>
    <br>
    <div id="publicRoutes">
        <?php
        echo '<h2 class="tableHeader">Public routes</h2>';
        echo $tables[PUBLIC_MODE];
        ?>
    </div>
    <br>
    <div id="privateRoutes">
        <?php
        echo '<h2 class="tableHeader">Private routes</h2>';
        echo $tables[PRIVATE_MODE];
        ?>
    </div>
    <br>
    <div id="teamRoutes">
        <?php
        echo '<h2 class="tableHeader">Team routes</h2>';
        echo $tables[TEAM_MODE];
        ?>
    </div>
    <br>

    <a href="../templates/newRoutePage.php">Add new route</a>

</div>
<script src="../static/sortTables.js"></script>
<script src="../static/addTableParameters.js"></script>

</body>
</html>

<?php

function showMessage() {
    $message = getInfoMessage();
    if ($message != null) {
        echo $message;
    }
}

function getInfoMessage() {

    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case NOT_ENOUGH_DATA:
                return '<div class="error-message-wide">Not enough data</div>';
            case ROUTE_ASSIGNED:
                return '<div class="success-message-wide">Route assigned</div>';
            case ROUTE_NOT_ASSIGNED:
                return '<div class="error-message-wide">Cannot assign route</div>';
            case ROUTE_ALREADY_ASSIGNED:
                return '<div class="error-message-wide">Route is already assigned as active</div>';

        }
    }

    return null;
}



?>

