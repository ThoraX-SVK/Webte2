<?php

include_once '../database/createConnection.php';

function getAddressIDSaveIfNeeded($streetName, $streetNumber, $city, $state, $psc) {

    $streetNameID = getStreetNameIDSaveIfNecessary($streetName);
    $cityID = getCityIDSaveIfNecessary($city);
    $stateID = getStateIDSaveIfNecessary($state);
    $pscID = getPscIDSaveIfNecessary($psc);

    $addressID = getAddress($streetNameID, $streetNumber, $cityID, $stateID, $pscID);

    if($addressID === null) {
        saveAddress($streetNameID, $streetNumber, $cityID, $stateID, $pscID);
        $addressID = getAddress($streetNameID, $streetNumber, $cityID, $stateID, $pscID);
    }

    return $addressID;
}

function getAddress($streetNameID, $streetNumber, $cityID, $stateID, $pscID) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.Address
                                      WHERE street_fk = ?
                                      AND  streetNumber = ?
                                      AND  city_fk = ?
                                      AND state_fk = ?
                                      AND  psc_fk = ?");
    $stmn->bind_param("iiiii", $streetNameID,$streetNumber, $cityID, $stateID, $pscID);
    $stmn->execute();
    $result = $stmn->get_result();

    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function saveAddress($streetNameID, $streetNumber, $cityID, $stateID, $pscID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.Address VALUES (DEFAULT, ?, ?, ?, ?, ?)");
    $stmn->bind_param("iiiii", $streetNameID,$streetNumber, $cityID, $stateID, $pscID);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}



/**************************************************************/

function getStreetNameIDSaveIfNecessary($streetName) {

    $streetNameID = getStreetNameID($streetName);

    if($streetNameID === null) {
        saveStreetName($streetName);
        $streetNameID = getStreetNameID($streetName);
    }

    return $streetNameID;
}

function getStreetNameID($streetName) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.Street WHERE streetName = ?");
    $stmn->bind_param("s", $streetName);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function saveStreetName($streetName) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.Street VALUES (DEFAULT, ?)");
    $stmn->bind_param("s", $streetName);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}

/******************************************************/

function getCityIDSaveIfNecessary($city) {

    $cityID = getCityID($city);

    if($cityID === null) {
        saveCity($city);
        $cityID = getCityID($city);
    }

    return $cityID;
}

function getCityID($city) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.City WHERE cityName = ?");
    $stmn->bind_param("s", $city);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function saveCity($city) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.City VALUES (DEFAULT, ?)");
    $stmn->bind_param("s", $city);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}

/****************************************************/

function getStateIDSaveIfNecessary($state) {

    $cityID = getStateID($state);

    if($cityID === null) {
        saveState($state);
        $cityID = getStateID($state);
    }

    return $cityID;
}

function getStateID($state) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.State WHERE stateName = ?");
    $stmn->bind_param("s", $state);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function saveState($state) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.State VALUES (DEFAULT, ?)");
    $stmn->bind_param("s", $state);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}

/******************************************************/

function getPscIDSaveIfNecessary($psc) {

    $cityID = getPscID($psc);

    if($cityID === null) {
        savePsc($psc);
        $cityID = getPscID($psc);
    }

    return $cityID;
}

function getPscID($psc) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.PSC WHERE pscNumber = ?");
    $stmn->bind_param("i", $psc);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['id'];
}

function savePsc($psc) {
    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("INSERT w2final.PSC VALUES (DEFAULT, ?)");
    $stmn->bind_param("i", $psc);
    $stmn->execute();

    $stmn->close();
    $conn->close();
}







