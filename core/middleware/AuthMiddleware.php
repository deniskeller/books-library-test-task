<?php

namespace BOOKSLibraryMIDDLEWARE;

use BOOKSLibraryROUTING\Route;

class AuthMiddleware
{
  public function handle($param = null)
  {
    if (!isset($_SESSION['user_id'])) {
      Route::redirect('/login');
    }
  }
}
