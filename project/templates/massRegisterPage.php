<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<?php
    // ERROR SHOWING
    include_once "../constants/registerConstants.php";

    $errorMessage = getErrorMessage();
    if ($errorMessage != null) {
        echo "<div class='register-status-message'>";
        echo $errorMessage;
        echo "</div>";
    }
?>


<form action="../controller/massRegistrationController.php" method="post" enctype="multipart/form-data">

    <!--  keep  -->
    <input type="file" name="file" id="file"/>

    <!--  keep  -->
    <input type="submit" name="submit"/>

</form>


<?php

function getErrorMessage()
{
    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case ERROR_USER_NOT_ADMIN:
                return "Only administrators can mass register users";
        }
    }

    return null;
}

?>

</body>
</html>