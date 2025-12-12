<?php

use BOOKSLibraryMODELS\Book;

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require_once __DIR__ . '/../config/config.php';
require_once ROOT . '/vendor/autoload.php';

$book = new Book('qwerty', price: 49.99);
dump($book);
dump($book->setCurrency());


// dump("Time:" . microtime(true) - $start_app);
