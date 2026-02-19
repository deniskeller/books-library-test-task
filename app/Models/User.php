<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;
use PDOException;

class User
{
  private Database $db;

  public function __construct()
  {
    $this->db = Database::getInstance();

    if (!$this->db->getConnection()) {
      throw new \RuntimeException('Нет подключения к базе данных');
    }
  }

  public function create($username, $password_hash): int|bool
  {
    try {
      return $this->db->insert('users', ['username' => $username, 'password_hash' => $password_hash]);
    } catch (PDOException $e) {
      error_log("[User::create] Ошибка регистрации пользователя: {$e->getMessage()} | Логин пользователя: {$username}");
      return false;
    }
  }

  public function isUsernameUnique(string $username): bool
  {
    try {
      $result = $this->db->fetch('SELECT * FROM users WHERE username = :username', ['username' => $username]);
      return $result === false;
    } catch (PDOException $e) {
      error_log("[User::isUsernameUnique] Ошибка проверки логина на уникальность: {$e->getMessage()} | Логин пользователя: {$username}");
      return false;
    }
  }

  public function getById($id)
  {
    try {
      return $this->db->fetch('SELECT * FROM authors WHERE id = :id', ['id' => $id]);
    } catch (PDOException $e) {
      error_log("[User::getById] Ошибка получения пользователя: {$e->getMessage()} | ID пользователя: {$id}");
      return null;
    }
  }
}
