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
    
$db->insertCategory($_POST['category'], $_POST['parent']);

}

$categories = $db->selectCategories();

echo $twig->render('admin.html', ['url' => $url,
    'categories' => $categories, 'user' => $user,
    'isadmin' => $isadmin]);