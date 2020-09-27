<?php

require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

session_start();


// $db = new Database($link);

// if (isset($_POST['submit'])) {
    
//     $search = $_POST['search'];

//     $searchArray = $db->searchTag($search);
    
// }

echo $twig->render('search.html', ['posts' => $_SESSION['searchArray']]);