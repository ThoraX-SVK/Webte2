<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/newTeamStyle.css">
    <meta charset="UTF-8">
    <title>Add new team</title>
</head>
<body>


<?php
include_once "../template_utils/menuGenerator.php";
include_once "../services/printUserSelectService.php";
include_once "../utils/sessionUtils.php";
include_once '../constants/teamConstants.php';

loginRequired(ADMIN_ROLE);
echo getMenu();
// error message
showMessage();
?>

<header>
    <h1>Create New Team</h1>
</header>
<div class="content">



    <form action="../controller/newTeamController.php" method="post">

        <input type="text" placeholder="Team name" name="teamName" required>
        <?php
            echo getUserSelect();
        ?>
        <input type="button" id="addUserToTeam" value="Add selected user">
        <br>
        <div id="addedUsers"></div>
        <br>
        <br>
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

        echo $message;
        echo "</div>";
    }
}

function getInfoMessage() {

    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case TEAM_SUCCESSFULLY_SAVED:
                return "<div class='success-message-wide'>Team was successfully saved";
            case TEAM_SAVING_FAILED:
                return "<div class='error-message-wide'>Team was NOT saved because of an unknown error";
        }
    }

    return null;
}

?>



