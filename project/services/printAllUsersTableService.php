<?php


include_once "../template_utils/tableGenerator.php";
include_once "../database/userUtils.php";
include_once "../utils/sessionUtils.php";


function getAllUsersTable() {

    $attrs = array("class" => "all-users-table", "id" => "all-users-table");
    $header = array("User ID", "Name", "Surname", "Email", "Is Activated", "User role");
    $content = array();

    $users = getAllUsers__FAKE();

    foreach ($users as $user) {
        $userRole = getUserRoleFromUserId__FAKE($user["userID"]);

        $userRoleDisplay = getUserRoleDisplayValue($userRole);

        $tableRow = array(
            $user["userID"],
            $user["name"],
            $user["surname"],
            $user["email"],
            $user["isActivated"] ? "Yes" : "No",
            $userRoleDisplay,
        );

        array_push($content, $tableRow);
    }

    return assembleTable($header, $content, $attrs);

}

function getUserRoleDisplayValue($userRole) {
    if ($userRole === null or !array_key_exists("role", $userRole)) {
        return "Unspecified (not supposed to happen)";
    }

    switch ($userRole["role"]) {
        case ADMIN_ROLE:
            return "Administrator";
        case USER_ROLE:
            return "Regular user";
        default:
            return "Unspecified (not supposed to happen)";

    }
}
