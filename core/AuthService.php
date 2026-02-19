<?php

namespace BOOKSLibraryCORE;

use BOOKSLibraryCORE\FormFieldValidator;
use BOOKSLibraryMODELS\User;

class AuthService
{
  private User $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }
  public function validateUserData(array $data, bool $login = false): array
  {
    $errors = [];

    $errors['username'] = FormFieldValidator::text($data['username'], [
      'fieldName' => 'Имя пользователя',
      'numbersAllowed' => true,
      'minLength' => 2,
      'maxLength' => 50,
    ]);

    $errors['password'] = FormFieldValidator::password($data['password'], [
      'required' => true,
      'minLength' => 8
    ]);

    if (!$login && !$this->userModel->isUsernameUnique($data['username'])) {
      $errors['username'] = 'Пользователь с таким логином уже существует';
    }

    return array_filter($errors);
  }
}
