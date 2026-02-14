<?php

namespace BOOKSLibraryMIDDLEWARE;

use BOOKSLibraryROUTING\Route;

class GuestMiddleware
{
  public function handle($param = null,)
  {

    if (isset($_SESSION['user_id'])) {
      Route::redirect('/');
    }
  }
}
