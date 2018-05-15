<?php
include_once "../utils/sessionUtils.php";

if (!isUserAdmin_YES__FAKE()) {
    header("Location: login.php");
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Mass Registration</title>
</head>

<body>

<?php
include_once "../template_utils/menuGenerator.php";

echo getMenu();

?>



<header>
    <h1>Admin :: Mass Registration</h1>
</header>

<div class="content">
    <?php
    // ERROR SHOWING
    include_once "../constants/registerConstants.php";

    $errorMessage = getErrorMessage();
    if ($errorMessage != null) {
        echo "<div class='register-status-message error-message'>";
        echo $errorMessage;
        echo "</div>";
    }
    ?>
<!--    <div class='error-message'>Only administrators can mass register users</div>--> <!--for testing purposes-->
<form action="../controller/massRegistrationController.php" method="post" enctype="multipart/form-data" class="middle-relative no-padding">

    <!--  keep  -->
    <input type="file" name="file" id="file"/>
    <br>
    <!--  keep  -->
    <input type="submit" name="submit"/>

</form>

</div>

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