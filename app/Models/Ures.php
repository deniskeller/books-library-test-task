<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;
use PDOException;

class Ures
{
  private Database $db;

  public function __construct()
  {
    $this->db = Database::getInstance();

    if (!$this->db->getConnection()) {
      throw new \RuntimeException('Нет подключения к базе данных');
    }
  }

  public function getById($id)
  {
    try {
      return $this->db->fetch('SELECT * FROM authors WHERE id = :id', ['id' => $id]);
    } catch (PDOException $e) {
      error_log("[Ures::getById] Ошибка получения пользователя: {$e->getMessage()} | ID пользователя: {$id}");
      return null;
    }
  }

  public function create($name): int
  {
    try {
      return $this->db->insert('authors', ['name' => $name]);
    } catch (PDOException $e) {
      error_log("[Ures::create] Ошибка регистрации пользователя: {$e->getMessage()} | Логин пользователя: {$name}");
      return false;
    }
  }
}
