<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\View;


class UserController
{
  public function login(): void
  {
    View::render('login');
  }

  public function registration(): void
  {
    View::render('registration');
  }

  public function logout(): void
  {
    View::render('logout');
  }
}
