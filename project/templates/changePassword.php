
<?php

function redirectIfLoggedIn() {

    if (isUserLoggedIn()) {
        header('location: ../templates/homePage.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Change password</title>
</head>
<body>


<div class="main">

    <form method="post" action="">
        <br><br><span>Old password</span>
        <br><input type="password" name="oldPassword" placeholder="Old password">
        <br><span>New password</span>
        <br><input type="password" name="newPassword" placeholder="New password">
        <br><span>Retype new password</span>
        <br><input type="password" name="retypeNewPassword" placeholder="Retype new password">
        <br><input type="submit">
    </form>

</div>

</body>
</html>


