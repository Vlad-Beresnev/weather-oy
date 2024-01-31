<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'taitaja2023');
define('DB_PASSWORD', "taitaja2023");
define('DB_NAME', 'weather_oy_db');

function connect() {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    return $conn;
}