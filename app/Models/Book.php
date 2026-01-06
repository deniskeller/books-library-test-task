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

    public function getAll($authorId = null): array
    {
        $sql = "SELECT books.id, books.title, books.year,
            GROUP_CONCAT(authors.id ORDER BY authors.id) as author_ids,
            GROUP_CONCAT(authors.name ORDER BY authors.id SEPARATOR ', ') as authors
            FROM books
            LEFT JOIN book_authors ON books.id = book_authors.book_id
            LEFT JOIN authors ON book_authors.author_id = authors.id";

        if ($authorId) {
            $sql .= " WHERE books.id IN (SELECT book_id FROM book_authors WHERE author_id = :authorId) GROUP BY books.id ORDER BY books.title";
            return $this->db->fetchAll($sql, ['authorId' => $authorId]);
        }

        $sql .= " GROUP BY books.id ORDER BY books.title";
        return $this->db->fetchAll($sql);
    }

    public function getById($id)
    {
        return $this->db->fetch('SELECT * FROM books WHERE id = :id', ['id' => $id]);
    }

    public function create($title, $year, $authors_ids): int
    {
        $data = [
            'title' => $title, 'year' => $year
        ];
        $book_id = $this->db->insert('books', $data);
        $this->addAuthorsToBook($book_id, $authors_ids);
        return $book_id;
    }

    public function deleteById($id): int
    {
        // удаление связей книги с авторами
        $sql = "DELETE FROM book_authors WHERE book_id = $id";
        $this->db->query($sql);

        return $this->db->delete('books', 'id = :id', ['id' => $id]);
    }

    public function update($id, $title, $year): int
    {
        return $this->db->update('books', ['title' => $title, 'year' => $year], 'id = ?', [$id]);
    }

    private function addAuthorsToBook($book_id, $author_ids): void
    {
        if (!empty($author_ids)) {
            foreach ($author_ids as $author_id) {
                $author_id = (int)$author_id;
                $sql = "INSERT INTO book_authors (book_id, author_id) VALUES ($book_id, $author_id)";
                $this->db->query($sql);
            }
        }
    }
}
