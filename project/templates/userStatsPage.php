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

echo getUserStatsTable($userID);

?>

</div>

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

