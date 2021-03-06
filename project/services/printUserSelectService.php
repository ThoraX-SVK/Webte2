<?php

include_once "../template_utils/selectGenerator.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";


function getUserSelect($attrs = null) {

    if ($attrs === null) {
        $attrs = array("name" => "userSelect", "id" => "userSelect");
    }
    $options = array();

    $users = getAllUsers();

    foreach ($users as $user) {
        $opt = "[" . $user["userID"] . "] " . $user["name"] . " " . $user["surname"] . " - " . $user["email"];
        array_push($options, array(
            "value" => $user["userID"],
            "inner" => $opt)
        );
    }

    return assembleSelect($options, $attrs);

}
