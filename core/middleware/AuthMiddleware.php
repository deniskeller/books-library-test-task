<?php

namespace BOOKSLibraryMIDDLEWARE;

use BOOKSLibraryROUTING\Route;

class AuthMiddleware
{
  public function handle()
  {
    if (!isset($_SESSION['user_id'])) {
      Route::redirect('/login');
    }
  }
}
