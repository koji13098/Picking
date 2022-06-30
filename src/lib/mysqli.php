<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

function dbConnect(): mysqli
{
    $link = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
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
