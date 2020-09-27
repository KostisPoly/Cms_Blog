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
$isadmin = $_SESSION['isadmin'];
$user = $_SESSION['user'];

if(isset($_POST['submit'])) {
    if (isset($_POST['create'])) {
        $author = $user;
    
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($post_image_temp, './assets/img/'.$post_image.'');
    
        $db->insertPost($_POST['category'], $_POST['title'],
            $author, date("Y-m-d H:i:s"), $post_image, $_POST['content'],
            $_POST['tags'] );
    
    } elseif ($_POST['edit']) {

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($post_image_temp, './assets/img/'.$post_image.'');
    
        $db->updatePost($_POST['category'], $_POST['title'], 
            $_POST['author'], $_POST['date'], $post_image, $_POST['content'], 
            $_POST['tags'], $_POST['status'], $_POST['edit'] );
    
        }elseif ($_POST['delete']) {
        echo 'THIS IS WHERE THE DELETE CODE GOES';
    }
    
}

$posts = $db->getPosts('admin');

$categories = $db->selectCategories();

$draftPosts = array_filter($posts, function ($row) {
    return ($row['post_status'] == 'draft');
});

//$countComments = $db->countComments();

echo $twig->render('admin.html', ['url' => $url, 'posts' => $posts,
    'draftposts' => $draftPosts, 'categories' => $categories,
    'user' => $user, 'isadmin' => $isadmin]);