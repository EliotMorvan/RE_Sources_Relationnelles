<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
define('UPLOAD_DIR', './upload/');

// Auto chargement de classes
function class_loader($class) {
    require __DIR__ . '/' . $class . '.php';
}
spl_autoload_register('class_loader');


// Connection à la base de données
$dsn       = 'mysql:dbname=php-oo;host=127.0.0.1;port=3307';
$user      = 'root';
$password  = 'root';

$connection = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
