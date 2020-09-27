<?php
//ob_start();
require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';



$db = new Database($link);

if (isset($_POST['submit'])) {
    
    $search = $_POST['search'];
    
    $searchArray = $db->searchTag($search);
    
    if(!empty($searchArray) && $search != '') {
        
        session_start();
        $_SESSION['searchArray'] = $searchArray;
        header('Location: search.php');
    }
    
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$categories = $db->selectCategories();

foreach ($categories as $key => $value) {
    
    if ($value['cat_parent_cat'] != '0') {
        $subcategories[] = $value;     
    }
}

$posts = $db->getPosts('index');
$lifePosts = $db->getLifePosts();
$betPosts = $db->getBetPosts();

$latestPosts = array_chunk($posts,3,true);
$latestpost1 = $latestPosts[0][0];
$latestpost2 = $latestPosts[0][1];
$latestpost3 = $latestPosts[0][2]; 

$count_pages = count($latestPosts) - 1;

$social = $db->getSocial();


echo $twig->render('index.html',
    ['categories' => $categories,
    'subcategories' => $subcategories,
    'posts' => $posts,
    'lifeposts' => $lifePosts,
    'betposts' => $betPosts,
    'latestposts' => $latestPosts,
    'latestpost1' => $latestpost1,
    'latestpost2' => $latestpost2,
    'latestpost3' => $latestpost3,
    'socials' => $social,
    'count_pages' => $count_pages
    ]);