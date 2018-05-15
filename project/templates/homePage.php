<?php
include_once "../utils/sessionUtils.php";
include_once "../database/userUtils.php";
if(getActiveUserID__FAKE()==null){
    header("Location: login.php");
}
else {
    $userID=getActiveUserID__FAKE();
}
if(findUsersActiveRoute__FAKE_NULL($userID)==null)
    {
        header("Location: homePageNoRoute.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php
showMessage();
?>

<form action="../controller/newRunController.php" method="POST">
    <input type="text" name="distanceTraveled">
    <input type="submit" value="Submit">
</form>

<?php

include_once '../constants/messageConstants.php';


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
            case RUN_SUCCESSFULLY_SAVED:
                return "Your run has been successfully saved";
            case RUN_SAVING_FAILED:
                return "There has been an error and your run has NOT been saved";
        }

    }

    return null;
}

?>

</body>
</html>

