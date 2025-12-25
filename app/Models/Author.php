<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;

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

    public function getAll(): array
    {
        return $this->db->fetchAll('SELECT * FROM authors');
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
}