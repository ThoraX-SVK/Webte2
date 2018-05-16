<?php

include_once '../database/createConnection.php';


function getAllNews() {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id, header, content, added FROM w2final.News");
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if (mysqli_num_rows($result) === 0) {
        return null;
    }

    $resArray = array();

    while ($row = $result->fetch_assoc()) {

        $toPush = array(
            'newsID' => $row['id'],
            'header' => $row['header'],
            'content' => $row['content'],
            'added' => $row['added'],
        );

        array_push($resArray, $toPush);
    }

    return $resArray;
}

function getAllNews__FAKE() {
    $resArray = array();
    $i = 0;

    while ($i < 15) {
        $i++;
        $toPush = array(
            'newsID' => $i,
            'header' => "header " . $i,
            'content' => "content " . $i,
            'added' => "added " . $i,
        );

        array_push($resArray, $toPush);
    }

    return $resArray;
}




