<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/allTeamStyle.css">
    <meta charset="UTF-8">
    <title>Teams</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";

echo getMenu();

?>

<header>
    <h1>All Teams</h1>
</header>

<div class="content">
    <?php
    include_once "../services/printTeamsTableService.php";
    include_once "../utils/sessionUtils.php";
    include_once  "../constants/teamConstants.php";
    include_once  "../constants/globallyUsedConstants.php";
    include_once "../database/teamUtils.php";

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

        $teamID = getTeamIdFromTeamName($key);

        echo "<h2>" . $key . "</h2>\n";
        echo '<a href="../controller/deleteTeamController.php?teamID=' . $teamID . '"  
                onclick="return confirm(\'Are you sure?\');">Delete team </a>';

        echo $table;

        echo "\n";
        echo "<br><hr>";
    }
}


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
                return '<div class="error-message-wide">Not enough POST data to save route</div>';
            case TEAM_SUCCESSFULLY_SAVED:
                return '<div class="success-message-wide">Team has been successfully saved</div>';
            case TEAM_SUCCESSFULLY_DELETED:
                return '<div class="success-message-wide">Team has been successfully deleted</div>';
            case TEAM_MEMBER_REMOVED:
                return '<div class="success-message-wide">Team member has been successfully removed</div>';

        }
    }

    return null;
}

?>



