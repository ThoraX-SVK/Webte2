<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Add new team</title>
</head>
<body>


<div class="main">
    <?php
    include_once "../services/printUserSelectService.php";
    include_once "../utils/sessionUtils.php";
    include_once '../constants/teamConstants.php';

    loginRequired(ADMIN_ROLE);

    // error message
    showMessage();
    ?>

    <form action="../controller/newTeamController.php" method="post">

        <input type="text" placeholder="Team name" name="teamName" required>

        <div id="addedUsers"></div>

        <br/>
        <?php
            echo getUserSelect();
        ?>
        <input type="button" id="addUserToTeam" value="Add selected user">

        <input type="submit" value="Save">

    </form>
</div>

<script src="../static/newTeamScript.js"></script>

</body>
</html>

<?php
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
            case TEAM_SUCCESSFULLY_SAVED:
                return "Team was successfully saved";
            case TEAM_SAVING_FAILED:
                return "Team was NOT saved because of an unknown error";
        }
    }

    return null;
}

?>



