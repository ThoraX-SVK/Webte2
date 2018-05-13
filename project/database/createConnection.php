<?php

function createConnectionFromConfigFileCredentials()
{
    $config = include "../config/config.php";

    $host = $config['host'];
    $user = $config['user'];
    $password = $config['password'];

    $connection = new mysqli($host, $user, $password);
    $connection->set_charset("utf8");

    if ($connection->connect_error) {
        die("Connection error: " . $connection->connect_error);
    }
    return $connection;
}


