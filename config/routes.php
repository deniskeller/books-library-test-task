<?php
$routes = [
    // роуты книг
    '' => ['controller' => 'BookController', 'method' => 'index'],
    'books/create' => ['controller' => 'BookController', 'method' => 'create'],
    'books/edit?{id}' => ['controller' => 'BookController', 'method' => 'edit'],
    // роуты авторов
    'authors' => ['controller' => 'AuthorController', 'method' => 'index'],
    'authors/create' => ['controller' => 'AuthorController', 'method' => 'create'],
    'authors/edit?{id}' => ['controller' => 'AuthorController', 'method' => 'edit']
];
