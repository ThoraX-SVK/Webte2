<?php

include_once "../constants/routeConstants.php";
include_once "../template_utils/selectGenerator.php";
include_once "../utils/sessionUtils.php";


function getRouteModeSelect() {

    $attrs = array("name" => "mode");
    $options = array(
        array (
            "value" => PRIVATE_MODE,
            "inner" => "Private route"
        )
    );

    if (isUserAdmin_YES__FAKE()) {
        array_push($options,
            array (
                "value" => PUBLIC_MODE,
                "inner" => "Public route"
            ),
            array (
                "value" => TEAM_MODE,
                "inner" => "Team route"
            )
        );
    }

    return assembleSelect($options, $attrs);

}
