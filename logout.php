<?php

require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

session_start();

$db = new Database($link);

$url = $_SERVER["REQUEST_URI"];

$dt = new DateTime();
$dt->format('Y-m-d H:i:s');
$db->setOnlineUser($_SESSION['user'], session_id(), $dt, 'logout');

$_SESSION['user'] = $_SESSION['email'] = $_SESSION['password'] = null;

header('Location: login.php');

echo $twig->render('admin-login.html', ['url' => $url]);