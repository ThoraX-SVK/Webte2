<?php
include_once "../utils/sessionUtils.php";

loginRequired(ADMIN_ROLE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/addNewsStyle.css">
    <meta charset="UTF-8">
    <title>Add news letter</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";
include_once "../constants/globallyUsedConstants.php";
include_once "../constants/newsConstants.php";

loginRequired(ADMIN_ROLE);
echo getMenu();

?>

<header>
    <h1>Add News Letter</h1>
</header>

<div class="content">

    <?php showErrorMessage(); ?>

    <form method="POST" action="../controller/addNewsController.php">
        <input type="text" placeholder="Enter header" name="header" required>
        <br><br><br><textarea onkeyup="auto_grow(this)" placeholder="Enter content of news" name="content"></textarea>
        <br><br><br><input type="submit" value="Publish">
    </form>


</div>


<script>
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }
</script>


</body>
</html>


<?php

function showErrorMessage() {
    $message = getErrorMessage();

    if ($message !== null) {
        echo $message;
    }

}

function getErrorMessage() {
    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case NOT_ENOUGH_DATA:
                return "Not enough data sent";
            case NEWS_SUCCESSFULLY_SAVED:
                return "Newsletter article published";
            case NEWS_SAVING_FAILED:
                return "Newsletter article saving failed";
        }

        return null;
    }
}

?>
