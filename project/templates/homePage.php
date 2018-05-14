<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap core CSS -->
    <!--<link rel="stylesheet" type="text/css" href="../static/bootstrap-material-design.min.css">-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../static/starter-template.css" type="text/css" rel="stylesheet">
    <script src="../static/homePage.js"></script>
    <title>Welcome!</title>
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Maps</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#" id="address">Map of users by address</a>
                    <a class="dropdown-item" href="#" id="school">Map of users by school</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<main role="main" class="container">
    <div class="starter-template">
        <div>
            <div id="map"></div>
            <script>
                function initMap() {
                    var uluru = [{lat: 48.28, lng: 17.82},{lat: 33.33, lng: 13.13}];
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 3,
                        center: uluru[0]
                    });
                    for(var i = 0;i < uluru.length;i++){
                        var marker = new google.maps.Marker({
                            position: uluru[i],
                            map: map
                        });
                    }
                }
            </script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4&callback=initMap">
            </script>
        </div>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
</body>
</html>


