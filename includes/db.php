<?php

// Database settings - Start
$host     = '127.0.0.1:3306';
$username = 'root';
$password = '';
$database = 'cms';					
// Database settings - End

//Server banchmark to find appropriate cost value

// $timeTarget = 0.05; // 50 milliseconds 
// $cost = 8;
// do {
//     $cost++;
//     $start = microtime(true);
//     password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
//     $end = microtime(true);
// } while (($end - $start) < $timeTarget);
// echo "Appropriate Cost Found: " . $cost;

$link = new mysqli($host, $username, $password, $database);

if ($link->connect_errno)
{
    die('Failed to connect to MySQL: (' . $link->connect_errno . ') ' . $link->connect_error);
} else {
    echo 'Connected to db<br>';
}