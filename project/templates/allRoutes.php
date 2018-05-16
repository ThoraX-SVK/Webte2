<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Home</title>
    <script>
        function showPublicRoutes() {
            if (document.getElementById("publicRoutes").style.display == "block") {
                document.getElementById("publicRoutesButton").value = "Show public routes";
                document.getElementById("publicRoutes").style.display = "none";
            }
            else {
                document.getElementById("publicRoutesButton").value = "Hide public routes";
                document.getElementById("publicRoutes").style.display = "block";
            }
        }

        function showPrivateRoutes() {
            if (document.getElementById("privateRoutes").style.display == "block") {
                document.getElementById("privateRoutesButton").value = "Show private routes";
                document.getElementById("privateRoutes").style.display = "none";
            }
            else {
                document.getElementById("privateRoutesButton").value = "Hide private routes";
                document.getElementById("privateRoutes").style.display = "block";
            }
        }

        function showTeamRoutes() {
            if (document.getElementById("teamRoutes").style.display == "block") {
                document.getElementById("teamRoutesButton").value = "Show team routes";
                document.getElementById("teamRoutes").style.display = "none";
            }
            else {
                document.getElementById("teamRoutesButton").value = "Hide team routes";
                document.getElementById("teamRoutes").style.display = "block";
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

?>


<header>
    <h1>All routes</h1>
</header>

<div class="content">
    <div id="routeButtonsHolder">
        <input type="button" onclick="showPublicRoutes()" value="Show public routes" id="publicRoutesButton">
        <input type="button" onclick="showPrivateRoutes()" value="Show private routes" id="privateRoutesButton">
        <input type="button" onclick="showTeamRoutes()" value="Show team routes" id="teamRoutesButton">
    </div>

    <?php
    include_once "../services/printRoutesTableService.php";
    include_once "../constants/routeConstants.php";

    $tables = getRouteTables();

    ?>
    <div id="publicRoutes">
        <?php
            echo "Public routes";
            echo $tables[PUBLIC_MODE];
        ?>
    </div>
    <div id="privateRoutes">
        <?php
            echo "Private routes";
            echo $tables[PRIVATE_MODE];
        ?>
    </div>
    <div id="teamRoutes">
        <?php
            echo "Team routes";
            echo $tables[TEAM_MODE];
        ?>
    </div>

</div>


</div>
</body>
</html>

