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
    <title>News Letter</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";
include_once "../utils/sessionUtils.php";

loginRequired();
echo getMenu();

?>


<header>
    <h1>News Letter</h1>
</header>

<div class="content">

    <!--TODO:This form should be handled by backend-->

    <form method="get" action="addNewsPage.php">
        <input type="text" placeholder="Enter header" name="newsHeader" required>
        <br><br><br><textarea onkeyup="auto_grow(this)" placeholder="Enter content of news" name="newsContent"></textarea>
        <br><br><br><input type="submit" value="Publish">
    </form>


</div>



</div>


</div>
<script>
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }
</script>



</body>
</html>
