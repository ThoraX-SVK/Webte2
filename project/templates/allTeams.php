<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Teams</title>
</head>
<body>


<div class="main">
    <?php
    include_once "../services/printTeamsTableService.php";
    include_once "../utils/sessionUtils.php";
    include_once  "../constants/routeConstants.php";

    loginRequired(ADMIN_ROLE);

    // error message
    showMessage();

    // team tables
    showTables();

    ?>

    <a href="../templates/newTeamPage.php">Add new team</a>

</div>


</body>
</html>

<?php

function showTables() {
    $tables = getTeamTables();

    foreach ($tables as $key => $table) {
        echo "<h2>" . $key . "</h2> \n";
        echo $table;

        echo "\n";
        echo "<br/>";
    }
}


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



