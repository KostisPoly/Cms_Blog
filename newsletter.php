<?php
//ob_start();
require_once __DIR__.'/init.php';
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/database.php';

$db = new Database($link);

if(isset($_POST['submit'])){
    var_dump($_POST);
}