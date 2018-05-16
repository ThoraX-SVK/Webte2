<?php


/**
 * @param $options - options in array of arrays with keys "value" and "inner" for each
 * @param null $attrs - HTML attributes of select
 *                    - example: array ("class => "klasa", "id" => "idecko")
 * @return string - select to be echo-ed
 */
function assembleSelect($options, $attrs = null) {

    $htmlAttrs = "";

    if ($attrs !== null) {
        foreach ($attrs as $key => $value) {
            $htmlAttrs .= $key . '=' . '"' . $value . '" ';
        }
    }

    $select = "<select " . $htmlAttrs . " >";

    foreach ($options as $opt) {
        if (!array_key_exists("value", $opt) or !array_key_exists("inner", $opt)) {
            continue;
        }
        $select .= assembleOption($opt["value"], $opt["inner"]);
        $select .= "\n";
    }

    $select .= "</select>";

    return $select;
}


function assembleOption($value, $inner) {

    $option = '<option value="' . $value . '">';
    $option .= $inner;
    $option .= '</option>';

    return $option;

}