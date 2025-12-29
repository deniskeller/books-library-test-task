<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;

class Book
{

    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();

        if (!$this->db->getConnection()) {
            throw new \RuntimeException('Нет подключения к базе данных');
        }
    }

    public function getAll(): array
    {
        return $this->db->fetchAll('SELECT * FROM books');
    }

    public function getById($id)
    {
        // сделать удаление связи с авторами
        return $this->db->fetch('SELECT * FROM books WHERE id = :id', ['id' => $id]);
    }

    public function create($name): int
    {
        return $this->db->insert('books', ['name' => $name]);
    }

    public function deleteById($id): int
    {
        return $this->db->delete('books', 'id = :id', ['id' => $id]);
    }

    public function update($id, $name): int
    {
        return $this->db->update('books', ['name' => $name], 'id = ?', [$id]);
    }
}
