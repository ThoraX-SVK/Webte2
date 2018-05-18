<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <link rel="stylesheet" type="text/css" href="../static/newsStyle.css">
    <meta charset="UTF-8">
    <title>News Letter</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";
include_once "../services/printNewsService.php";
include_once "../services/printUserSubscriptionInfoService.php";

loginRequired();
echo getMenu();

$userID = getActiveUserID();
if ($userID === null) {
    // what the fuck could have happened?
    exit;
}

showMessage();
?>

<header>
    <h1>News Letter</h1>

    <h2><?php echo getUserSubscriptionOptions($userID) ?></h2>
</header>

<div class="content">

    <?php
        printNews();

        echo getPreviousPageLink();
        echo " <<" . getPage() . ">> ";
        echo getNextPageLink();
    ?>
</body>
</html>

<?php


function printNews() {
    $news = printNewsByPage(getPage(), 5);

    if (sizeof($news) === 0) {
        echo "<h2>No more news</h2>";
        return;
    }

    foreach ($news as $item) {
        echo $item;
    }
}

function getPage() {

    if (isset($_GET["page"])) {
        return $_GET["page"];
    }

    return 1;
}

function getPreviousPageLink() {
    $page = getPage();

    if ($page - 1 !== 0) {
        return '<a href="../templates/newsPage.php?page=' . ($page - 1) . '">Previous Page</a>';
    } else {
        return "";
    }
}


function getNextPageLink() {
    $page = getPage();

    if (sizeof(getNewsForGivenPage($page + 1, 5)) > 0) {
        return '<a href="../templates/newsPage.php?page=' . ($page + 1) . '">Next Page</a>';
    } else {
        return "";
    }
}

function showMessage() {
    $message = getInfoMessage();
    if ($message != null) {
        echo $message;
    }
}

function getInfoMessage() {

    if (isset($_GET["status"])) {

        $status = $_GET["status"];

        switch ($status) {
            case SUBSCRIBED:
                return '<div class="success-message-wide">Subscribed</div>';
            case UNSUBSCRIBED:
                return '<div class="success-message-wide">Unsubscribed</div>';
        }
    }

    return null;
}

?>