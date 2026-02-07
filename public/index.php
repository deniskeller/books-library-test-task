<?php

use BOOKSLibraryROUTING\Route;

session_start();

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require __DIR__ . '/../config/config.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/database/Database.php';
require ROUTING . '/web.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Route();
$router->dispatch();

//dump("Time:" . microtime(true) - $start_app);
