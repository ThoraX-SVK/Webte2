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
            "school" => "SKOLA",
            "schoolAddress" => "SKOLAAD",
            "address" => "ADRESA",
            "PSC" => "PSC",
            "city" => "MESTO"
        )
    );

    return array(
        "successful" => $results,
        "failed" => array()
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

        $isSaveSuccessful = saveUserWithAdditionalData__SUCCESS__FAKE(
            $user["email"],
            $user["name"],
            $user["surname"],
            $user["password"],
            $user["school"],
            $user["schoolAddress"],
            $user["address"],
            $user["PSC"],
            $user["city"]
        );

        if ($isSaveSuccessful == FAILED) {
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
        $userDataToPush = array(
            "surname" => $matrix[$i][1],
            "name" => $matrix[$i][2],
            "email" => $matrix[$i][3],
            "school" => $matrix[$i][4],
            "schoolAddress" => $matrix[$i][5],
            "address" => $matrix[$i][6],
            "PSC" => $matrix[$i][7],
            "city" => $matrix[$i][8],
        );

        array_push($labeledArray, $userDataToPush);
    }

    return $labeledArray;

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



