<?php
$routes = [
    '' => ['controller' => 'BookController', 'method' => 'index'],
    'authors' => ['controller' => 'AuthorController', 'method' => 'index'],
    'authors/view/{id}' => ['controller' => 'AuthorController', 'method' => 'view'],
    'books' => ['controller' => 'BookController', 'method' => 'index'],
    'books/view/{id}' => ['controller' => 'BookController', 'method' => 'view'],
];