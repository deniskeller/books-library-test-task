<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;
use Exception;

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

    //    авторы вместе с счетчком книг
    public function getAll(): array
    {
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
    }

    public function getById($id)
    {
        return $this->db->fetch('SELECT * FROM authors WHERE id = :id', ['id' => $id]);
    }

    public function create($name): int
    {
        return $this->db->insert('authors', ['name' => $name]);
    }

    public function deleteById($id): int
    {
        return $this->db->delete('authors', 'id = :id', ['id' => $id]);
    }

    public function update($id, $name): int
    {
        try {
            $this->db->update('authors', ['name' => $name], 'id = ?', [$id]);

            return true;
        } catch (Exception $e) {
            error_log('Ошибка редактирования автора: ' . $e->getMessage());
            return false;
        }
    }
}
