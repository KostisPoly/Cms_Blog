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
    if(isset($_POST['edit'])) {
        $db->updateComment($_POST['author'], $_POST['email'], 
            $_POST['content'], $_POST['date'], $_POST['status'], $_POST['edit'] );
    }
}

$comments = $db->getComments();

$draftComments = array_filter($comments, function ($row) {
    return ($row['com_status'] == 'draft');
});

echo $twig->render('admin.html', ['url' => $url, 'comments' => $comments,
    'draftcomments' => $draftComments,
    'user' => $user, 'isadmin' => $isadmin]);