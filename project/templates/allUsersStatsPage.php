<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/allRoutesTableStyle.css">
    <meta charset="UTF-8">
    <title>All users stats</title>


</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";
include_once  "../constants/routeConstants.php";

loginRequired(ADMIN_ROLE);

loginRequired();
echo getMenu();

?>


<header>
    <h1>All User Stats</h1>
</header>

<div class="content">


    <!--TODO: print all users stats tables here-->

</div>

</body>
</html>

