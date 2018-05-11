<?php

/**
 *  Every call to database that somehow handles users goes here
 */


function getUserIdFromEmail__FAKE($email) {
    return 1;
}

function getUserIdFromEmail($email) {

    //TODO: Call DB, return email userID if there is, null if not

    return null;
}

function isEmailAlreadyInDatabase__FAKE($email) {
    return true;
}

function isEmailAlreadyInDatabase($email) {
    return getUserIdFromEmail($email) == null ? false : true;
}


function getUserFromUserId__FAKE($userID) {

    //TODO: Add more stuff to represent user, might be class in future
    return array(
        'userID' => 1,
        'passwordHash' => 'hash',
        'salt' => 'salt',
        'name' => 'Jozko',
        'surname' => 'Mrkvicka',
        'City' => 'Bratislava'
    );
}

function getUserFromUserId($userID) {

    //TODO: Call DB, get real user data

    return null;
}


function saveUserToDB_SUCCESS__FAKE($email, $param) {
    return true;
}

function saveUserToDB($email, $param) {

}

function findUsersActiveRoute__FAKE($userID) {
    return 1;
}

function findUsersActiveRoute($userID) {

    //TODO: Look in DB and find his active routeID

}







