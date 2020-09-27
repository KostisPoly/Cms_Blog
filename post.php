<?php

require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

//cache control repost without redirect
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();

$db = new Database($link);

if(isset($_GET['post_id'])) {
    $post = $db->getPost($_GET['post_id']);
}

$user = "";
$email = "";

if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

if(isset($_POST['submit'])) {
    
    if(isset($_POST['signup'])) {
        
        $db->signUser($_POST['username'],$_POST['password'],$_POST['firstname'],$_POST['lastname'],$_POST['email']);
    }elseif (isset($_POST['login'])) {
        $userArray = $db->loginUser($_POST['email'], $_POST['password']);
        $user = $_SESSION['user'] = $userArray['us_username'];
        $isadmin = $_SESSION['isadmin'] = $userArray['us_isadmin'];
        $email = $_SESSION['email'] = $_POST['email'];
    }elseif (isset($_POST['comment'])) {
        
        if(isset($_SESSION['user']) && isset($_SESSION['email']) && isset($_GET['post_id'])){
            $db->insertComment($_GET['post_id'], $_SESSION['user'], $_SESSION['email'], $_POST['content'], date("Y-m-d H:i:s"));
        }else{
            //not in session maybe redirect home
        }
    }
}


$categories = $db->selectCategories();

foreach ($categories as $key => $value) {
    
    if ($value['cat_parent_cat'] != '0') {
        $subcategories[] = $value;     
    }
}

echo $twig->render('post.html', ['categories' => $categories,
    'subcategories' => $subcategories,
    'post' => $post,
    'user' => $user]);