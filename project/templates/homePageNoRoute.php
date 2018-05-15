<?php
include_once "../utils/sessionUtils.php";
include_once "../database/userUtils.php";
if(getActiveUserID__FAKE()==null){
    header("Location: login.php");
}
else {
    $userID=getActiveUserID__FAKE();
}
if(findUsersActiveRoute__FAKE_NULL($userID)!=null)
{
    header("Location: homePage.php");
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
<!--TODO: add new function to template-utils that prints whole menu bar -->
<div class="topnav">
    <a href="about.php">About</a>
    <a href="login.php">Login</a>
    <a href="homePage.php">Home</a>
    <a href="routesPage.php">Routes</a>

    <?php
    //TODO: only echo these options if user is admin
    if (isUserAdmin_YES__FAKE()) {
        echo '<div class="topnav-right">';
        echo '<a class="active" href="massRegisterPage.php">Registrations</a>';
        echo '</div>';
    }
    ?>

</div>



<header>
    <h1>Home Page</h1>
</header>

<div class="content">
    You have no active route yet. You can either select one of <a href="routes.php"><em><strong> available routes</strong></em></a> or <a href="createRoute.php"><em><strong> create a new one</strong></em></a>.

</div>



</body>
</html>