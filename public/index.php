<?php

use BOOKSLibraryMODELS\Book;
use BOOKSLibraryMODELS\BookExtends;
use BOOKSLibraryMODELS\Library;

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require_once __DIR__ . '/../config/config.php';
require_once ROOT . '/vendor/autoload.php';

$book = new Book('qwerty', 700);
$book2 = new Book('qwerty2', 1200);
$library = new Library();
//dump($library->addBook($book)->addBook($book2)->getTotalPice());
//dump($library);


$book_extends = new BookExtends('qwerty3', 500, 10);

//dump($book_extends);
//dump($book_extends->title);
//dump($book->getInfo());
//dump($book_extends->getInfo());
dump($book_extends->getPrivate());
$book_extends->setPrivate('kek');
dump($book_extends->getPrivate());

// dump("Time:" . microtime(true) - $start_app);
