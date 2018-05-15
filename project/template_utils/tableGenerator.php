<?php

define('TABLE_HEADER', 'TABLE_HEADER');
define('TABLE_NORMAL', 'TABLE_NORMAL');

function assembleTable($header, $content) {

    $table = "<table>";

    if ($header === null or $content === null) {
        return "NULL TABLE DATA";
    }

    $table .= assembleTableRow($header, TABLE_HEADER);

    foreach ($content as $values) {
        $table .= assembleTableRow($values, TABLE_NORMAL);
    }

    $table .= "</table>";

    return $table;
}


function assembleTableRow($values, $type) {
    $row = "";
    $row .= "<tr>";

    foreach ($values as $value) {
        $row .= assembleTableColumn($value, $type) . "\n";
    }

    $row .= "</tr> \n";
    return $row;
}

function assembleTableColumn($value, $type) {

    if ($type === TABLE_HEADER) {
        $open = "<th>";
        $close = "</th>";
    } else {
        $open = "<td>";
        $close = "</td>";
    }

    return $open . $value . $close;
}