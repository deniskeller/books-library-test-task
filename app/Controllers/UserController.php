<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\AuthService;
use BOOKSLibraryCORE\View;
use BOOKSLibraryMODELS\User;
use BOOKSLibraryROUTING\Route;

class UserController
{
  private User $userModel;
  private AuthService $authService;
  public function __construct()
  {
    $this->userModel = new User();
    $this->authService = new AuthService();
  }
  public function loginShow(): void
  {
    $title = 'Вход';
    View::render('login', compact('title'));
  }

  public function login(): void
  {
    $username = trim($_POST['username']) ?? '';
    $password = trim($_POST['password']) ?? '';
    $login = true;
    $errors = $this->authService->validateUserData($_POST, $login);

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;
      $_SESSION['old_data'] = $_POST;
      Route::redirect('/login');
    }

    $user = $this->userModel->getUser($username);

    if ($user && password_verify($password, $user['password_hash'])) {
      unset($_SESSION['old_data']);
      unset($_SESSION['errors']);
      $_SESSION['user_id'] = 'auth';
      $_SESSION['user_name'] = $user['username'];
      $_SESSION['user_role'] = $user['user_role'];

      $_SESSION['success'] = 'Вы успешно авторизовались';
      Route::redirect('/');
    } else {
      $_SESSION['old_data'] = $_POST;
      $_SESSION['error'] = 'Неверный логин или пароль';
      Route::redirect('/login');
    }
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

    $errors = $this->authService->validateUserData($_POST);

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

  public function logout(): void
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      abort(405);
    }

    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);

    $_SESSION['success'] = 'Вы успешно вышли из профиля';

    Route::redirect('/');
  }
}
