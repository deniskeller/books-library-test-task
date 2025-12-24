<?php

use BOOKSLibraryMODELS\Author;

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/database/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$authors = new Author();

require CORE . '/router.php';

//dump("Time:" . microtime(true) - $start_app);
