<?php
include_once "../utils/sessionUtils.php";

loginRequired(ADMIN_ROLE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../static/style.css">
    <meta charset="UTF-8">
    <title>Admin :: Documentation</title>
</head>
<body>
<?php
include_once "../template_utils/menuGenerator.php";

echo getMenu();

?>

<header>
    <h1>Documentation</h1>
</header>

<div class="content" style="text-align:left";>
    This page is a semestral project for Web technologies 2. Its purpose is to enable users to log their runs (or drives) and watch as their set goals (routes) are being fulfilled. For example their goal can be to run 1000km. They can create their own private route and then add every one of their runs into this route.
    <br><br> All users can also participate in public events, as "Lets run together around the world". Any user can contribute into these events. The last type or routes are team routes, which can be contributed into only by given team.
    <br><br> Orientation on the page should be pretty easy, thanks to menu bar on top of the page. On the left side it consists of "Home", "Routes", "News", "My Stats" and "About" links. On the right side there is a "Sign Out" button, that is accompanied by more buttons, if user is also an admin. These buttons enable mass registrations, adding news, viewing all users and also all teams.
    <br><br><br> This whole page was created with use of GitHub and by 5 students. Different people were responsible for different areas of development.
    <br>
    <p style="font-weight: bold">
    <br>Tomáš Krasoň - Database + SQL
    <br>Timotej Bezák - Backend
    <br>Libor Sestrienka - Frontend
    <br>Matúš Rybár - Frontend
    <br>Ľuboš Petrovič - Google Maps
    </p>

</div>
</body>
</html>



