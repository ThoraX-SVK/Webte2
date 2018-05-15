<?php

define('TABLE_HEADER', 'TABLE_HEADER');
define('TABLE_NORMAL', 'TABLE_NORMAL');


/**
 * @param $header - array of string to be displayed in <tr> (each in <th>) of size N
 * @param $content - array of arrays of string to be displayed in table content (<td>)
 *                 - MxN matrix means M x <tr> and N x <td> in them
 * @param null $attrs - HTML attributes of the resulting table
 *                    - example: array ("class => "klasa", "id" => "idecko")
 * @return string - table to be echo-ed
 */
function assembleTable($header, $content, $attrs = null) {

    if ($header === null or $content === null) {
        return "NULL TABLE DATA";
    }

    $htmlAttrs = "";

    if ($attrs !== null) {
        foreach ($attrs as $key => $value) {
            $htmlAttrs .= $key . '=' . '"' . $value . '" ';
        }
    }

    $table = "<table " . $htmlAttrs . " >";

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