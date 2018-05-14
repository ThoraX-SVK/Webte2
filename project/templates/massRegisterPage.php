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
    <h1>Admin :: Mass Registration</h1>
</header>

<div class="content">

<form action="../controller/massRegistrationController.php" method="post" enctype="multipart/form-data" class="middle-relative">

    <!--  keep  -->
    <input type="file" name="file" id="file"/>
    <br>
    <br>
    <!--  keep  -->
    <input type="submit" name="submit"/>

</form>

</div>



</body>
</html>