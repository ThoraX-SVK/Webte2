<?php
include_once "../utils/sessionUtils.php";

loginRequired(ADMIN_ROLE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
    <h1>Admin :: Mass Registration from CSV file</h1>
</header>

<?php
// ERROR SHOWING
include_once "../constants/registerConstants.php";
include_once "../constants/globallyUsedConstants.php";

$errorMessage = getErrorMessage();
if ($errorMessage != null) {
    echo "<div class='register-status-message error-message-wide'>";
    echo $errorMessage;
    echo "</div>";
}
?>

<div class="content">



    <!--    <div class='error-message'>Only administrators can mass register users</div>--> <!--for testing purposes-->
    <form action="../controller/massRegistrationController.php" method="post" enctype="multipart/form-data"
          class="middle-relative no-padding">

        <!--  keep  -->
        <input type="file" name="file" id="file"/>
        <br>
        <!--  keep  -->
        <input type="submit" name="submit">

    </form>

    <!--  response from AJAX is a table to be stored in this div  -->
    <div id="results-table"></div>

</div>

<?php

function getErrorMessage() {
    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case ERROR_USER_NOT_ADMIN:
                return 'Only administrators can mass register users';
        }
    }

    return null;
}

?>

<script>
    if ((document.getElementsByClassName("error-message")[0]) || (document.getElementsByClassName("success-message")[0])) {
        document.getElementsByClassName("content")[0].style.padding = "0px";
    }
</script>
<script src="../static/ajaxCsvFileUpload.js"></script>

</body>
</html>