<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<h3 align="center">
<?php
    echo getPageContents();
?>
</h3>

</body>
</html>


<?php

function getEmail() {
    $email = "";

    if (isset($_GET["email"])) {
        $email = $_GET["email"];
    }

    return $email;
}

function getPageContents() {
    $email = getEmail();
    return "Prosím skontrolujte svoj email $email pre potvrdenie registrácie a aktiváciu svojho používateľského účtu.";
}

?>