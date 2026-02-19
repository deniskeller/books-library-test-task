<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\UserService;
use BOOKSLibraryCORE\View;
use BOOKSLibraryMODELS\User;
use BOOKSLibraryROUTING\Route;

class UserController
{
  private User $userModel;
  private UserService $userService;
  // public array $errors = [];
  public function __construct()
  {
    $this->userModel = new User();
    $this->userService = new UserService();
  }
  public function loginShow(): void
  {
    // $_SESSION['user_id'] = 'auth';
    // $_SESSION['user_name'] = 'Denis';
    // $_SESSION['user_role'] = 'user';
    // $_SESSION['user_role'] = 'admin';
    $title = 'Вход';
    View::render('login', compact('title'));
  }

  public function login(): void
  {
    $username = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';

    $errors = $this->userService->validateUserData($_POST);

    dump($errors);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_data'] = $_POST;
      Route::redirect('/login');
    }

    // $password_hash = password_hash($password, PASSWORD_DEFAULT);
    // $response = $this->userModel->create($username, $password_hash);

    // if ($response) {
    //   unset($_SESSION['old_data']);
    //   unset($_SESSION['errors']);
    //   $_SESSION['user_id'] = 'auth';
    //   $_SESSION['user_name'] = $username;
    //   $_SESSION['user_role'] = 'user';

    //   $_SESSION['success'] = 'Вы успешно зарегистрировались';
    //   Route::redirect('/');
    // } else {
    //   $_SESSION['error'] = 'Ошибка при регистрации';
    //   Route::redirect('/register');
    // }
  }

  public function logout(): void
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);

    View::render('logout');
  }

  public function registerShow(): void
  {
    $title = 'Регистрация';
    View::render('register', compact('title'));
  }

  public function register(): void
  {
    $username = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';

    $errors = $this->userService->validateUserData($_POST);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_data'] = $_POST;
      Route::redirect('/register');
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $response = $this->userModel->create($username, $password_hash);

    if ($response) {
      unset($_SESSION['old_data']);
      unset($_SESSION['errors']);
      $_SESSION['user_id'] = 'auth';
      $_SESSION['user_name'] = $username;
      $_SESSION['user_role'] = 'user';

      $_SESSION['success'] = 'Вы успешно зарегистрировались';
      Route::redirect('/');
    } else {
      $_SESSION['error'] = 'Ошибка при регистрации';
      Route::redirect('/register');
    }
  }
}
