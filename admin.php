<?php

require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

session_start();

if( !isset($_SESSION['email']) && !isset($_SESSION['password']) && !isset($_SESSION['user']) ) {
    header('Location: login.php');
}

$db = new Database($link);

$url = $_SERVER["REQUEST_URI"];

$user = $_SESSION['user'];

$onlineUsersArray = $db->getOnlineUsers();

echo $twig->render('admin.html', ['url' => $url, 'user' => $user, 'onlineusers' => $onlineUsersArray]);