<?php

use BOOKSLibraryMODELS\Author;

$title = 'Страница авторов';

if (!isset($authors)) {
    die('База данных не доступна');
}
$authors = new Author();


$allAuthors = $authors->fetchAll('SELECT * FROM authors');

//try {
//    $authors->insert('authors', [
//        'name' => 'Лермонтов2233 Михаил Юрьевич',
//    ]);
//} catch (PDOException $e) {
//    echo "Ошибка базы данных: " . $e->getMessage();
//}


//dd_v($title);
//namespace BOOKSLibraryCONTROLLERS;
//
//class AuthorsController
//{
//
//    public function __construct(
//        public string $title = 'Страница авторов',
//    )
//    {
//        dd_v($this->title);
//    }
//
//}

require_once VIEWS . '/pages/authors.php';