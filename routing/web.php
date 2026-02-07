<?php

use BOOKSLibraryCONTROLLERS\AuthorController;
use BOOKSLibraryCONTROLLERS\BookController;
use BOOKSLibraryROUTING\Route;


// роуты книг
Route::get('', [BookController::class, 'index']); // Главная страница
Route::get('books/create', [BookController::class, 'create']);
Route::post('books/store', [BookController::class, 'store']);
Route::get('books/{id}/edit', [BookController::class, 'edit']);
Route::put('books/{id}/update', [BookController::class, 'update']);
Route::delete('books/{id}/destroy', [BookController::class, 'destroy']);
// роуты авторов
Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/create', [AuthorController::class, 'create']);
Route::post('authors/store', [AuthorController::class, 'store']);
Route::get('authors/{id}/edit', [AuthorController::class, 'edit']);
Route::put('authors/{id}/update', [AuthorController::class, 'update']);
Route::delete('authors/{id}/destroy', [AuthorController::class, 'destroy']);
