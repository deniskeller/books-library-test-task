<?php

namespace BOOKSLibraryMIDDLEWARE;

use BOOKSLibraryROUTING\Route;

class AuthMiddleware
{
  public function handle($param = null)
  {
    // echo 'запуска миддлвера админ';
    if (!isset($_SESSION['user_id'])) {
      // echo 'вы не админ';
      Route::redirect('/login');
    }
  }
}
