<?php

require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

session_start();

$db = new Database($link);

$url = $_SERVER["REQUEST_URI"];

if(isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $userArray = $db->loginUser($_SESSION['email'], $_SESSION['password']);
    $_SESSION['user'] = $user = $userArray['us_username'];
    $_SESSION['isadmin'] = $isadmin = $userArray['us_isadmin'];
    $currentSessionId = session_id();

    if ($user != '') {
        
        $dt = new DateTime();
        $dateTime = $dt->format('Y-m-d H:i:s');
        
        $db->setOnlineUser($_SESSION['user'], $currentSessionId, $dateTime, 'login');
        header('Location: admin.php');
    }else{
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
}

echo $twig->render('admin-login.html', ['url' => $url]);