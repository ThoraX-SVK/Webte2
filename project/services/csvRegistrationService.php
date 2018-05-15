<?php

include_once "../services/saveUserService.php";
include_once "../security/randomPasswordGenerator.php";


define('CSV_START_LINE', 1);
define('CSV_LINE_DELIMITER', "\n");
define('CSV_COLUMN_DELIMITER', ";");


function processCsvFileAndSaveUsers__FAKE($csv) {

    $results = array(
        array (
            "surname" => "PRIEZV",
            "name" =>"MENO",
            "email" => "EMAIL",
            "password" => "HESLO",
            "schoolName" => "SKOLA",
            "schoolStreet" => "SKOLAAD",
            "schoolStreetNo" => "SKOLA2",
            "schoolPSC" => "SKOLAPSC",
            "schoolCity" => "MESTO",
            "userStreet" => "ULICA",
            "userStreetNo" => "12",
            "userCity" => "MESTO",
            "userPSC" => "54556",
        )
    );

    $failedResults = array(
        array (
            "surname" => "FAIL",
            "name" =>"FAIL",
            "email" => "FAIL EMAIL",
            "password" => "HESLO",
            "schoolName" => "SKOLA",
            "schoolStreet" => "SKOLAAD",
            "schoolStreetNo" => "SKOLA2",
            "schoolPSC" => "SKOLAPSC",
            "schoolCity" => "MESTO",
            "userStreet" => "ULICA",
            "userStreetNo" => "12",
            "userCity" => "MESTO",
            "userPSC" => "54556",
            "FAILURE_REASON" => ERROR_EMAIL_INVALID
        )
    );

    return array(
        "successful" => $results,
        "failed" => $failedResults
    );
}


function processCsvFileAndSaveUsers($csv) {
// use this function to save every user saveUser(), check if return is not === FAILED, if not, we can say
//that user is in DB

    $rawData = handleFile($csv);
    $userLabeledData = labelUserLoadedCSVMatrix($rawData);
    $failedUsers = array();
    $successfulUsers = array();

    //for every user
    foreach ($userLabeledData as $user) {
//        $user["password"] = createRandomPassword__FAKE(null);
        $user["password"] = "passWORD";

        $result = saveUserSuccess__FAKE("", "", "", "", "");

        if ($result["status"] == FAILED) {
            $user["FAILURE_REASON"] = $result["reason"];
            array_push($failedUsers, $user);
        } else {
            array_push($successfulUsers, $user);
        }
    }

    return array (
        "successful" => $successfulUsers,
        "failed" => $failedUsers
    );
}


/**
 * returns a Matrix from CSV file (given by $_FILES[input name])
 * matrix_line represents a single CSV entry
 * matrix_column represents a piece of information in given line
 * @param $file
 * @return array|null
 */
function handleFile($file) {

    $fileContents = file_get_contents($file["tmp_name"]);
    $resultsMatrix = array();

    if (!$fileContents) {
        return null;
    }

    $firstLine = explode(CSV_LINE_DELIMITER, $fileContents);

    for ($i = CSV_START_LINE; $i < sizeof($firstLine) - 1; $i++) {

        $lineElements = explode(CSV_COLUMN_DELIMITER, $firstLine[$i]);

        array_push($resultsMatrix, $lineElements);
    }

    return $resultsMatrix;
}


function labelUserLoadedCSVMatrix($matrix) {
    $labeledArray = array();

    for ($i = 0; $i < sizeof($matrix); $i++) {
        $userAddress = parseStreet($matrix[$i][6]);
        $schoolAddress = parseSchoolAddress($matrix[$i][5]);

        $userDataToPush = array(
            "surname" => $matrix[$i][1],
            "name" => $matrix[$i][2],
            "email" => $matrix[$i][3],
            "schoolName" => $matrix[$i][4],
            "schoolStreet" => $schoolAddress["schoolStreet"],
            "schoolStreetNo" => $schoolAddress["schoolStreetNo"],
            "schoolCity" => $schoolAddress["schoolCity"],
            "schoolPSC" => $schoolAddress["schoolPSC"],
            "userStreet" => $userAddress["streetname"],
            "userStreetNo" => $userAddress["streetnumber"],
            "userPSC" => $matrix[$i][7],
            "userCity" => $matrix[$i][8]
        );

        array_push($labeledArray, $userDataToPush);
    }

    printData_DEBUG($labeledArray);
    return $labeledArray;

}

function parseStreet($string) {
    if ( preg_match('/([^\d]+)\s?(.+)/i', $string, $result) ) {

        $result[1] = trim($result[1]);
        $result[2] = trim($result[2]);

        return array (
            "streetname" => $result[1],
            "streetnumber" => $result[2]
        );
    } else {

        return array (
            "streetname" => $string,
            "streetnumber" => ""
        );
    }
}

function parseSchoolAddress($string) {
    $schoolAddress = explode(",", $string);
    foreach ($schoolAddress as &$val) {
        $val = trim($val);
    }
    $schoolStreet = parseStreet($schoolAddress[1]);

    $toReturn = array (
        "schoolStreet" => $schoolStreet["streetname"],
        "schoolStreetNo" => $schoolStreet["streetnumber"],
        "schoolCity" => $schoolAddress[0],
        "schoolPSC" => $schoolAddress[2]
    );

    return $toReturn;
}


function printData_DEBUG($resultsMatrix) {
    echo "\n <br/>";
    //var_dump($resultsMatrix);
    foreach ($resultsMatrix as $line) {
        foreach ($line as $val) {
            echo $val . "\n <br/>";

        }
        echo "-------------------------- \n <br/>";
    }
}



