<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\View;


class UserController
{
  public function login(): void
  {
    // $_SESSION['user_id'] = 'auth';
    // $_SESSION['user_name'] = 'Denis';
    // $_SESSION['user_role'] = 'user';
    // $_SESSION['user_role'] = 'admin';
    View::render('login');
  }

  public function registration(): void
  {
    $title = 'Регистрация';
    // $_SESSION['user_id'] = 'auth';
    // $_SESSION['user_name'] = 'Denis';
    // $_SESSION['user_role'] = 'user';

    View::render('registration', compact('title'));
  }

  public function logout(): void
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);

    View::render('logout');
  }
}
