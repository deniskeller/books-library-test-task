<?php

namespace BOOKSLibraryMIDDLEWARE;

use BOOKSLibraryROUTING\Route;

class GuestMiddleware
{
  public function handle($param = null,)
  {
    // echo 'запуска миддлвера гость';
    if (isset($_SESSION['user_id'])) {
      Route::redirect('/');
    }
  }
}
