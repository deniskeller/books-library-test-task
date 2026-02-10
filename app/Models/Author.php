<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;
use Exception;
use PDOException;

class Author
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();

        if (!$this->db->getConnection()) {
            throw new \RuntimeException('Нет подключения к базе данных');
        }
    }

    //    авторы вместе со счетчиком книг
    public function getAll(): ?array
    {
        try {
            return $this->db->fetchAll('
            SELECT
                authors.id,
                authors.name,
                COUNT(book_authors.book_id) as book_counter
            FROM authors
            LEFT JOIN book_authors ON authors.id = book_authors.author_id
            GROUP BY authors.id
            ORDER BY authors.name
        ');
        } catch (PDOException $e) {
            error_log("[Author::getAll] Ошибка получения списка авторов: {$e->getMessage()}");
            return null;
        }
    }

    public function getById($id)
    {
        try {
            return $this->db->fetch('SELECT * FROM authors WHERE id = :id', ['id' => $id]);
        } catch (PDOException $e) {
            error_log("[Author::getById] Ошибка получения автора: {$e->getMessage()} | ID автора: {$id}");
            return null;
        }
    }

    public function create($name): int
    {
        try {
            return $this->db->insert('authors', ['name' => $name]);
        } catch (PDOException $e) {
            error_log("[Author::create] Ошибка создания автора: {$e->getMessage()} | Имя автора: {$name}");
            return false;
        }
    }

    public function deleteById($id): int
    {
        try {
            return $this->db->delete('authors', 'id = :id', ['id' => $id]);
        } catch (PDOException $e) {
            error_log("[Author::deleteById] Ошибка удаления автора: {$e->getMessage()} | Id автора: {$id}");
            return false;
        }
    }

    public function update($id, $name): int
    {
        try {
            $this->db->update('authors', ['name' => $name], 'id = ?', [$id]);

            return true;
        } catch (PDOException $e) {
            error_log("[Author::update] Ошибка при редактировании автора: {$e->getMessage()} | Id автора: {$id}");
            return false;
        }
    }
}
