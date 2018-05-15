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

echo getMenu();

?>


<header>
    <h1>Home Page</h1>
</header>

<div class="content">
    <div id="routeButtonsHolder">
        <input type="button" onclick="showPublicRoutes()" value="Show public routes" id="publicRoutesButton">
        <input type="button" onclick="showPrivateRoutes()" value="Show private routes" id="privateRoutesButton">
        <input type="button" onclick="showTeamRoutes()" value="Show team routes" id="teamRoutesButton">
    </div>
    <div id="publicRoutes"><!--TODO: echo here table of public routes--></div>
    <div id="privateRoutes"><!--TODO: echo here table of private routes--></div>
    <div id="teamRoutes"><!--TODO: echo here table of team routes--></div>


    <?php
    include_once "../services/printRoutesTableService.php";

    echo getRouteTables();

    ?>

</div>


</div>
</body>
</html>
