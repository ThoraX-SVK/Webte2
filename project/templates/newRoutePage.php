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

    loginRequired();
    ?>

    <form action="../controller/newRouteController.php" method="post">

        <!--    fill from google map API i guess?    -->
        <input type="hidden" placeholder="" name="distance" value="100" required>
        <input type="hidden" placeholder="" name="startLatitude" value="42" required>
        <input type="hidden" placeholder="" name="startLongitude" value="17" required>
        <input type="hidden" placeholder="" name="endLatitude" value="43" required>
        <input type="hidden" placeholder="" name="endLongitude" value="17" required>

        <input type="text" placeholder="Route name" name="routeName" required>

        <?php
            echo getRouteModeSelect();
        ?>

        <?php
            echo getTeamsSelect();
        ?>

        <input type="submit" value="Save">

    </form>


</div>

</body>
</html>

<?php



?>



