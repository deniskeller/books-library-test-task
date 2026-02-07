<?php

use BOOKSLibraryCONTROLLERS\BookController;
use BOOKSLibraryROUTING\Route;

Route::get('/', [BookController::class, 'index']);
