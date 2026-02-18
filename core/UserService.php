<?php

namespace BOOKSLibraryCORE;

use BOOKSLibraryCORE\FormFieldValidator;
use BOOKSLibraryMODELS\User;

class UserService
{
  private User $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }
  public function validateUserData(array $data): array
  {
    $errors = [];

    $errors['username'] = FormFieldValidator::text($data['username'], [
      'fieldName' => 'Имя пользователя',
      'minLength' => 2,
      'maxLength' => 50,
    ]);

    $errors['password'] = FormFieldValidator::password($data['password'], [
      'required' => true,
      'minLength' => 8
    ]);

    if (!$this->userModel->isUsernameUnique($data['username'])) {
      $errors['username'] = 'Пользователь с таким логином уже существует';
    }

    return array_filter($errors);
  }
}
