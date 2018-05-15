<?php

include_once "../database/routeUtils.php";
include_once "../constants/routeConstants.php";
include_once "../template_utils/tableGenerator.php";



function getRoutesWithMode($mode) {
    return array();
}

function getRouteTables() {
    $routes = array();

    array_push($routes, array(PRIVATE_MODE => getRoutesWithMode(PRIVATE_MODE)));
    array_push($routes, array(PUBLIC_MODE => getRoutesWithMode(PUBLIC_MODE)));
    array_push($routes, array(TEAM_MODE => getRoutesWithMode(TEAM_MODE)));

    $header = array();
    $tables[PRIVATE_MODE] = assembleTable($header, $routes[PRIVATE_MODE]);
    $tables[PUBLIC_MODE] = assembleTable($header, $routes[PUBLIC_MODE]);
    $tables[TEAM_MODE] = assembleTable($header, $routes[TEAM_MODE]);

    $test = array(
      array(
        "a" => "AAA",
        "b" => "BBB",
        "c" => "CCC",
        "d" => "DDD"
      ),

      array(
        "a" => "AAA",
        "b" => "BBB",
        "c" => "CCC",
        "d" => "DDD"
      ),

      array(
        "a" => "AAA",
        "b" => "BBB",
        "c" => "CCC",
        "d" => "DDD"
      ),
    );

    $htmlAttrs = array ("class" => "table-routes", "id" => "table-routes");
    return assembleTable(array(), $test, $htmlAttrs);
}

