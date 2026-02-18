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
  public function login(): void
  {
    // $_SESSION['user_id'] = 'auth';
    // $_SESSION['user_name'] = 'Denis';
    // $_SESSION['user_role'] = 'user';
    // $_SESSION['user_role'] = 'admin';
    View::render('login');
  }

  public function logout(): void
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);

    View::render('logout');
  }

  public function registration(): void
  {
    $title = 'Регистрация';
    // $_SESSION['user_id'] = 'auth';
    // $_SESSION['user_name'] = 'Denis';
    // $_SESSION['user_role'] = 'user';

    View::render('registration', compact('title'));
  }

  public function store(): void
  {
    $username = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';
    // dump($username);
    // dump($password);

    // Валидация данных
    $errors = $this->userService->validateUserData($_POST);
    dump($errors);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_data'] = $_POST;
      Route::redirect('/registration');
    }

    $response = $this->userModel->create($username, $password);

    if ($response) {
      unset($_SESSION['old_data']);
      unset($_SESSION['errors']);

      $_SESSION['success'] = 'Вы успешно зарегистрировались';
      Route::redirect('/');
    } else {
      $_SESSION['error'] = 'Ошибка при регистрации';
      Route::redirect('/registration');
    }
  }
}
