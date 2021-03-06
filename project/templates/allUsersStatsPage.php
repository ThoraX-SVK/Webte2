<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/allUsersStatsStyle.css">
    <meta charset="UTF-8">
    <title>All users stats</title>


</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../services/printAllUsersTableService.php";
include_once "../utils/sessionUtils.php";

loginRequired(ADMIN_ROLE);

echo getMenu();

?>


<header>
    <h1>Admin :: All User Stats</h1>
</header>

<div class="content" style="width: 1000px">

    <?php

    echo getAllUsersTable();

    ?>

</div>
<script src="../static/sortTables.js"></script>
<script src="../static/addTableParameters.js"></script>


</body>
</html>

