<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/allRoutesTableStyle.css">
    <meta charset="UTF-8">
    <title>User stats</title>


</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";
include_once "../services/printUsersStatsTableService.php";
include_once "../services/checkIfUserExistsService.php";
include_once "../services/calculateAverageSpeedService.php";

loginRequired();

echo getMenu();

$userID = getUserID();
if (!checkIfUserExists($userID)) {
    redirectToAllUsersPage();
}

?>


<header>
    <h1>User stats</h1>
</header>

<div class="content">


    <?php

    echo getUserInfo($userID);

    echo getUserStatsTable($userID);

    echo "<b>Average speed for all runs:</b> " . getAverageSpeedOfUser($userID) . " [km/h]<br> \n";

    ?>

</div>
<script src="../static/sortTables.js"></script>
<script src="../static/addTableParameters.js"></script>
</body>
</html>

<?php

function getUserID() {
    if (isset($_GET["userID"])) {
        return $_GET["userID"];
    } else {
        redirectToAllUsersPage();
        return null;
    }
}

function redirectToAllUsersPage() {
    header("location: ../templates/allUsersStatsPage.php");
    exit;
}


?>

