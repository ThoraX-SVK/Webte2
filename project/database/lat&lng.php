<?php
function latlong()
{
    include_once '../database/createConnection.php';

    $conn = createConnectionFromConfigFileCredentials();

    $sql = "SELECT id,street_fk,streetNumber,city_fk,state_fk FROM w2final.Address";
    $result = $conn->query($sql);

    $i = 0;
    while ($rows = $result->fetch_assoc()) {
        if($rows['state_fk'] != NULL){
            $sql3 = "SELECT stateName FROM w2final.State WHERE id = " . $rows['state_fk'];
            $result3 = $conn->query($sql3);
            while ($row = $result3->fetch_assoc()) {
                $address = str_replace(" ", "+", $row['stateName']);
            }
        }
        if($rows['city_fk'] != NULL) {
            $sql2 = "SELECT cityName FROM w2final.City WHERE id = " . $rows['city_fk'];
            $result2 = $conn->query($sql2);
            while ($row = $result2->fetch_assoc()) {
                $address = $address . "+" . str_replace(" ", "+", $row['cityName']);
            }
        }
        if($rows['street_fk'] != NULL) {
            $sql1 = "SELECT streetName FROM w2final.Street WHERE id = " . $rows['street_fk'];
            $result1 = $conn->query($sql1);
            while ($row = $result1->fetch_assoc()) {
                $address = $address . "+" . $row['streetName'];
            }
        }
        if($rows['streetNumber'] != NULL) {
            $address = $address . "+" . $rows['streetNumber'];
        }
        if($rows['state_fk'] != NULL) {
            $latlng[$i][0] = NULL;
            $latlng[$i][1] = NULL;
            while ($latlng[$i][0] == NULL || $latlng[$i][1] == NULL) {
                $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
                $output = json_decode($geocode);
                $latlng[$i][0] = $output->results[0]->geometry->location->lat;
                $latlng[$i][1] = $output->results[0]->geometry->location->lng;
            }
            $sql4 = "SELECT * FROM w2final.User WHERE address_fk =" . $rows['id'];
            $result4 = $conn->query($sql4);
            $k = 0;
            while ($row = $result4->fetch_assoc()) {
                $k++;
            }
            if ($k > 0) {
                $latlng[$i][2] = "1";
            } else {
                $latlng[$i][2] = "0";
            }
            $sql5 = "SELECT * FROM w2final.School WHERE address_fk =" . $rows['id'];
            $result5 = $conn->query($sql5);
            $k = 0;
            while ($row = $result5->fetch_assoc()) {
                $k++;
            }
            if ($k > 0) {
                $latlng[$i][3] = "1";
            } else {
                $latlng[$i][3] = "0";
            }

            echo $latlng[$i][0]." ".$latlng[$i][1]." ".$latlng[$i][2]." ".$latlng[$i][3]."<br>";

            $i++;
        }
    }
    $conn->close();
    return $latlng;
}
latlong();
?>