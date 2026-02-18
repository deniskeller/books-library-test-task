<?php

namespace BOOKSLibraryCORE;

use BOOKSLibraryDATABASE\Database;
use BOOKSLibraryCORE\FormFieldValidator;
use PDOException;

class UserService
{
  private Database $db;

  public function __construct()
  {
    $this->db = Database::getInstance();

    if (!$this->db->getConnection()) {
      throw new \RuntimeException('Нет подключения к базе данных');
    }
  }
  public function isUsernameUnique(string $username): bool
  {
    try {
      return $this->db->fetch('SELECT * FROM users WHERE username = :username', ['username' => $username]);
    } catch (PDOException $e) {
      error_log("[UserService::isUsernameUnique] Ошибка проверки логина на уникальность: {$e->getMessage()} | Логин пользователя: {$username}");
      return false;
    }
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

    return array_filter($errors);
  }
}
