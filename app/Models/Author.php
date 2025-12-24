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

    public function getAllAuthors(): array
    {
        return $this->db->fetchAll('SELECT * FROM authors');
    }

    public function getById($id)
    {
        return $this->db->fetch('SELECT * FROM authors WHERE id = :id', ['id' => $id]);
    }
}