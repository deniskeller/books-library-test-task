<?php
return [
    // Главная страница
    '' => ['controller' => 'BookController', 'method' => 'index'],
    // роуты книг
    'books/create' => ['controller' => 'BookController', 'method' => 'create'],
    'books/edit?{id}' => ['controller' => 'BookController', 'method' => 'edit'],
    // роуты авторов
    'authors' => ['controller' => 'AuthorController', 'method' => 'index'],
    'authors/create' => ['controller' => 'AuthorController', 'method' => 'create'],
    'authors/edit?{id}' => ['controller' => 'AuthorController', 'method' => 'edit']


    // 'GET /' => 'BookController@index',
    // Книги
    // 'GET /books' => 'BookController@index',
    // 'GET /books/create' => 'BookController@create',
    // 'POST /books' => 'BookController@store',
    // 'GET /books/{id}' => 'BookController@show',
    // 'GET /books/{id}/edit' => 'BookController@edit',
    // 'PUT /books?{id}' => 'BookController@update',
    // 'DELETE /books/{id}' => 'BookController@destroy',

    // // Авторы
    // 'GET /authors' => 'AuthorController@index',
    // 'GET /authors/{id}' => 'AuthorController@show',
];
