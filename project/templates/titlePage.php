<!DOCTYPE html>
<html>
<head>
    <title>Welcome!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            position: relative;
            background: none;
        }
        html {
            background: url('../images/bgimage.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        #section1 {padding-top:75px;height:600px;}
        #section2 {padding-top:75px;height:600px;}
        #section3 {padding-top:75px;height:600px;}
        div.info {
            top: 100px;
            bottom: 50px;
            left: 0;
            right: 0;
            width: 400px;
            height: 500px;
            margin: auto;
            text-align:center;
            border: 5px solid black;
            border-radius: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            font-family: Arial, Times, serif;
            font-size: 60px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Page for true runners</a>
        </div>
        <div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="#section1">Info</a></li>
                    <li><a href="#section2">Map by addresses</a></li>
                    <li><a href="#section3">Map by schools</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./register.php">Register</a></li>

                    <?php

                    include_once "../utils/sessionUtils.php";
                    if (!isUserLoggedIn()) {
                        echo '<li><a href="./login.php">Login</a></li>';
                    } else {
                        echo '<li><a href="./homePage.php">logged in</a></li>';
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>
</nav>
<div id="section1" class="container-fluid">
    <div class="info">
        Welcome!
        <h1>Page is made for final assignment from subject WebTech2.</h1>
    </div>
</div>
<div id="section2" class="container-fluid">
    <div id="map" style="height:500px;width:100%"></div>
</div>
<div id="section3" class="container-fluid">
    <div id="map1" style="height:500px;width:100%"></div>
</div>
<!-- JS nakonci setri load time -->
<script>
    function initMap() {
        var uluru = [
            <?php
            require_once("../database/lat&lng.php");
            $lonlat = latlong();
            for ($i = 0;$i<count($lonlat);$i++){
                if($lonlat[$i][2] == 1){
                    echo "{lat: ".$lonlat[$i][0].", lng: ".$lonlat[$i][1]."}";
                }
                if($i != count($lonlat)-1 && $lonlat[$i][2] == 1)
                    echo ",";
            }
            ?>
        ];
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 48.18, lng: 18.18},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        for(i = 0;i < uluru.length;i++){
            var marker = new google.maps.Marker({
                position: uluru[i],
                map: map
            });
        }
        var uluru1 = [
            <?php
            require_once("../database/lat&lng.php");
            $lonlat = latlong();
            for ($i = 0;$i<count($lonlat);$i++){
                if($lonlat[$i][3] == 1){
                    echo "{lat: ".$lonlat[$i][0].", lng: ".$lonlat[$i][1]."}";
                }
                if($i != count($lonlat)-1 && $lonlat[$i][3] == 1)
                    echo ",";
            }
            ?>
        ];
        var map1 = new google.maps.Map(document.getElementById('map1'), {
            zoom: 7,
            center: {lat: 48.18, lng: 18.18},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        for(i = 0;i < uluru1.length;i++){
            var marker = new google.maps.Marker({
                position: uluru1[i],
                map: map1
            });
        }
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBr8NV5cYhZlxoFvyaRrusfcmAMM7IQMw4&callback=initMap">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
