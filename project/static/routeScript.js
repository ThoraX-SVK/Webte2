var fei = {lat: 48.153913, lng: 17.073994};
var startingPoint = null;
var map;
function myMap() {
    var mapOptions = {
        center: fei,
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAPS
    }
    map = new google.maps.Map(document.getElementById("map"), mapOptions);




    /* Pridanie markeru a jeho popisu na FEI */

    var contentString = '<div id="content"> <p><b> FEI STU BLOK E </b><br><br> dĺžka: 48.153913 <br> šírka: 17.073994 </p> </div>';

    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });


    var marker1 = new google.maps.Marker({
        position: fei,
        map: map,
        title: "FEI"
    });

    marker1.addListener('click', function()
    {
        infowindow.open(map, marker1);
    });

    var geocoder = new google.maps.Geocoder();

    document.getElementById("find").addEventListener("click", function () {
        geocodeAddress(geocoder, map);
    });

    /* Google maps path finding */
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    directionsDisplay.setMap(map);

    document.getElementById("path").addEventListener("click", function () {
        findRoute(directionsService, directionsDisplay);
    });

    document.getElementById("select-transport").addEventListener("change", function () {
        if (startingPoint != null)
            findRoute(directionsService, directionsDisplay);
    });





    /* Google maps Street View */
    var panorama = new google.maps.StreetViewPanorama(
        document.getElementById('streetview'), {
            position: fei,
            pov: {
                heading: 265,
                pitch: 0
            }
        });

    /* vyhľadaj zatávky blízko */

    map.setStreetView(panorama);

    var service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
        location: fei,
        radius: 5000,
        type: ['bus_station']
    }, callback);



}
/* spôsob prepravy */
/* https://developers.google.com/maps/documentation/javascript/directions */
function findRoute(dirService, dirDisplay) {

    var selectedTravelMode = document.getElementById("select-transport-options").value;

    dirService.route({
        origin: startingPoint.getPosition(),
        destination: fei,
        travelMode: selectedTravelMode
    }, function (response, status) {
        if (status === 'OK')
        {
            dirDisplay.setDirections(response);
            /* dĺžka trasy */
            document.getElementById("distance-value").innerHTML = response.routes[0].legs[0].distance.value + " metrov";

        } else {
            window.alert('Directions request failed due to ' + status
            )
            ;
        }
    });

}

function geocodeAddress(geocoder, map) {

    var address = document.getElementById("geocode_input").value;

    geocoder.geocode({"address": address}, function (results, status) {

        if (status === "OK") {
            if (startingPoint != null)
                startingPoint.setMap(null);

            startingPoint = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });


            map.setCenter(results[0].geometry.location);

        } else {
            alert('Geocoding request failed due to ' +status
            )
            ;
        }
    })
}

function callback(results, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    }
}

function createMarker(place) {
    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
    });


}



