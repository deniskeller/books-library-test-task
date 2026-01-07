<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;
use Exception;

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
            GROUP_CONCAT(authors.name ORDER BY authors.name SEPARATOR ', ') as authors
            FROM books
            LEFT JOIN book_authors ON books.id = book_authors.book_id
            LEFT JOIN authors ON book_authors.author_id = authors.id";

        if ($authorId) {
            $sql .= " WHERE books.id IN (SELECT book_id FROM book_authors WHERE author_id = :authorId) GROUP BY books.id";
            return $this->db->fetchAll($sql, ['authorId' => $authorId]);
        }

        $sql .= " GROUP BY books.id";
        return $this->db->fetchAll($sql);
    }

    public function getAuthorsByBookId($bookId): array
    {
        return $this->db->fetchAll("
            SELECT a.* FROM authors a
            INNER JOIN book_authors ba ON a.id = ba.author_id
            WHERE ba.book_id = ?
            ORDER BY a.name
        ", [$bookId]);
    }

    public function getById($id)
    {
        $book = $this->db->fetch('SELECT * FROM books WHERE id = :id', ['id' => $id]);

        if ($book) {
            $book['authors'] = $this->getAuthorsByBookId($id);
        }
        return $book;
    }

    public function deleteById($id): int
    {
        $sql = "DELETE FROM book_authors WHERE book_id = $id";
        $this->db->query($sql);

        return $this->db->delete('books', 'id = :id', ['id' => $id]);
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


    public function update($id, $title, $year, $authors_ids = []): int
    {
        try {
            $this->db->update('books', ['title' => $title, 'year' => $year], 'id = ?', [$id]);
//        удаляем старые связи
            $this->removeAllAuthorsFromBook($id);
            // добавляетм новые связи
            $this->addAuthorsToBook($id, $authors_ids);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function addAuthorsToBook($book_id, $author_ids): void
    {
        if (!empty($author_ids)) {
            foreach ($author_ids as $author_id) {
                $sql = "INSERT INTO book_authors (book_id, author_id) VALUES (?, ?)";
                $this->db->query($sql, [$book_id, $author_id]);
            }
        }
    }

    private function removeAllAuthorsFromBook($bookId): void
    {
        $this->db->query("DELETE FROM book_authors WHERE book_id = ?", [$bookId]);
    }
}
