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
$isadmin = $_SESSION['isadmin'];

if(isset($_POST['submit'])) {
    if(isset($_POST['edit'])) {
        $db->updateUser($_POST['username'], $_POST['password'], 
            $_POST['firstname'], $_POST['lastname'], $_POST['email'],
            $_POST['role'], $_POST['isadmin'], $_POST['edit'] );
    
    }elseif (isset($_POST['create'])) {
        $db->insertUser($_POST['username'], $_POST['password'], $_POST['firstname'],
            $_POST['lastname'], $_POST['email'], $_POST['role'], $_POST['isadmin']);
    }
}

$users = $db->getUsers();

$draftUsers = array_filter($users, function ($row) {
    return ($row['us_role'] == 'draft');
});

echo $twig->render('admin.html', ['url' => $url, 'users' => $users,
    'draftusers' => $draftUsers, 'user' => $user, 'isadmin' => $isadmin]);