<?php

require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

session_start();

$db = new Database($link);

$url = $_SERVER["REQUEST_URI"];

$email = '';
$password = '';

if (isset($_POST['submit'])) {
    if( isset($_POST['email']) && isset($_POST['password']) ){
        $email = $_SESSION['email'] = $_POST['email'];
        $password = $_SESSION['password'] = $_POST['password'];
        header('Location: admin-login.php');
    }
    
}


echo $twig->render('login.html', ['url' => $url,
    'email' => $email,
    'password' => $password]);