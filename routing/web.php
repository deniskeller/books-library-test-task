<?php

use BOOKSLibraryCONTROLLERS\AuthorController;
use BOOKSLibraryCONTROLLERS\BookController;
use BOOKSLibraryCONTROLLERS\UserController;
use BOOKSLibraryROUTING\Route;

const MIDDLEWARE = [
  'auth' => \BOOKSLibraryMIDDLEWARE\AuthMiddleware::class
];

// страницы входа
Route::get('login', [UserController::class, 'index']);
// роуты книг
Route::get('', [BookController::class, 'index']); // Главная страница
Route::get('books/create', [BookController::class, 'create']);
Route::post('books/store', [BookController::class, 'store']);
Route::get('books/{id}/edit', [BookController::class, 'edit'])->middleware('auth');
Route::put('books/{id}', [BookController::class, 'update']);
Route::delete('books/{id}', [BookController::class, 'destroy']);
Route::get('books/{id}/category/{category}', [BookController::class, 'show']); // тестовый роут для нескольких параметров
// роуты авторов
Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/create', [AuthorController::class, 'create']);
Route::post('authors/store', [AuthorController::class, 'store']);
Route::get('authors/{id}/edit', [AuthorController::class, 'edit']);
Route::put('authors/{id}', [AuthorController::class, 'update']);
Route::delete('authors/{id}', [AuthorController::class, 'destroy']);
