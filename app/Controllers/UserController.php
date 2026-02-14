<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\View;


class UserController
{
  public function index(): void
  {
    View::render('login');
  }
}
