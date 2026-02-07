<?php
return [
    // Главная страница
    '' => ['controller' => 'BookController', 'method' => 'index'],
    // роуты книг
    'books/create' => ['controller' => 'BookController', 'method' => 'create'],
    'books/store' => ['controller' => 'BookController', 'method' => 'store'],
    'books/edit?{id}' => ['controller' => 'BookController', 'method' => 'edit'],
    'books/update?{id}' => ['controller' => 'BookController', 'method' => 'update'],
    'books/destroy?{id}' => ['controller' => 'BookController', 'method' => 'destroy'],
    // роуты авторов
    'authors' => ['controller' => 'AuthorController', 'method' => 'index'],
    'authors/create' => ['controller' => 'AuthorController', 'method' => 'create'],
    'authors/store' => ['controller' => 'AuthorController', 'method' => 'store'],
    'authors/edit?{id}' => ['controller' => 'AuthorController', 'method' => 'edit'],
    'authors/update?{id}' => ['controller' => 'AuthorController', 'method' => 'update'],
    'authors/destroy?{id}' => ['controller' => 'AuthorController', 'method' => 'destroy']
];
