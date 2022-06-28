<?php

function dbConnect(): mysqli
{
    $link = mysqli_connect('db', 'picker', 'pass', 'store');
    if (!$link) {
        echo 'Error: Failed to connect to store' . PHP_EOL;
        echo mysqli_connect_error() . PHP_EOL;
    }

    return $link;
}

// $mysqli = new mysqli('db', 'picker', 'pass', 'store');

// if ($mysqli->connect_error) {
//     echo 'Error: Failed to connect to store' . PHP_EOL;
//     exit();
// } else {
//     echo 'Connected to store' . PHP_EOL;
// }
