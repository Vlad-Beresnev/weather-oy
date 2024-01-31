<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'taitaja2023');
define('DB_PASSWORD', "b3E1APd9iR9Iyr3j");
define('DB_NAME', 'weather_oy_database');

function connect() {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    return $conn;
}