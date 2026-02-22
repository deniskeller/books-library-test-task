<?php

namespace BOOKSLibraryMODELS;

use BOOKSLibraryDATABASE\Database;
use PDOException;

class Book
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();

        if (!$this->db->getConnection()) {
            throw new PDOException('Нет подключения к базе данных');
        }
    }

    public function getTotalCount($authorId = null)
    {
        try {
            $sql = 'SELECT COUNT(*) FROM books';
            if ($authorId) {
                $sql .= " LEFT JOIN book_authors ON books.id = book_authors.book_id LEFT JOIN authors ON book_authors.author_id = authors.id WHERE authors.id = :authorId";
                return $this->db->fetchColumn($sql, ['authorId' => $authorId]);
            }
            return $this->db->fetchColumn($sql);
        } catch (PDOException $e) {
            error_log("[Book::getTotalCount] Ошибка получения общего кол-ва книг: {$e->getMessage()}");
            return null;
        }
    }

    public function getAll($authorId = null, $offset = 0, $limit = 3): ?array
    {
        try {
            $sql = "SELECT books.id, books.title, books.year,
            GROUP_CONCAT(authors.name ORDER BY authors.name SEPARATOR ', ') as authors
            FROM books
            LEFT JOIN book_authors ON books.id = book_authors.book_id
            LEFT JOIN authors ON book_authors.author_id = authors.id";

            if ($authorId) {
                $sql .= " WHERE books.id IN (SELECT book_id FROM book_authors WHERE author_id = :authorId) GROUP BY books.id LIMIT $limit OFFSET $offset";
                return $this->db->fetchAll($sql, ['authorId' => $authorId]);
            }

            $sql .= " GROUP BY books.id LIMIT $limit OFFSET $offset";
            return $this->db->fetchAll($sql);
        } catch (PDOException $e) {
            error_log("[Book::getAll] Ошибка получения списка книг: {$e->getMessage()}");
            return null;
        }
    }

    public function getAuthorsByBookId($bookId): array
    {
        try {
            // запрос с алиасами
            return $this->db->fetchAll("
            SELECT a.* FROM authors a
            INNER JOIN book_authors ba ON a.id = ba.author_id
            WHERE ba.book_id = ?
            ORDER BY a.name
        ", [$bookId]);
        } catch (PDOException $e) {
            error_log("[Book::getAuthorsByBookId] Ошибка получения авторов книги: {$e->getMessage()} | ID книги: {$bookId}");
            return [];
        }
    }

    public function getById(int $id): ?array
    {
        try {
            $book = $this->db->fetch('SELECT * FROM books WHERE id = :id', ['id' => $id]);
            if (!$book) {
                return null;
            }
            $book['authors'] = $this->getAuthorsByBookId($id);
            return $book;
        } catch (PDOException $e) {
            error_log("[Book::getById] Ошибка получения книги: {$e->getMessage()} | ID книги: {$id}");
            return null;
        }
    }

    public function deleteById($id): int
    {
        try {
            $this->db->query("DELETE FROM book_authors WHERE book_id = ?", [$id]);
            return $this->db->delete('books', 'id = ?', [$id]);
        } catch (PDOException $e) {
            error_log("[Book::deleteById] Ошибка удаления книги: {$e->getMessage()} | Id книги: {$id}");
            return false;
        }
    }

    public function create($title, $year, $authors_ids): int
    {
        try {
            $data = [
                'title' => $title,
                'year' => $year
            ];

            $book_id = $this->db->insert('books', $data);
            $this->addAuthorsToBook($book_id, $authors_ids);

            return $book_id;
        } catch (PDOException $e) {
            error_log("[Book::create] Ошибка создания книги: {$e->getMessage()} | Название книги: {$title}");
            return false;
        }
    }

    public function update($id, $title, $year, $authors_ids = []): int
    {
        try {
            $this->db->update('books', ['title' => $title, 'year' => $year], 'id = ?', [$id]);
            // удаляем старые связи
            $this->removeAllAuthorsFromBook($id);
            // добавляетм новые связи
            $this->addAuthorsToBook($id, $authors_ids);

            return true;
        } catch (PDOException $e) {
            error_log("[Book::update] Ошибка при редактировании книги: {$e->getMessage()} | Название книги: {$title}");
            return false;
        }
    }

    private function addAuthorsToBook($book_id, $author_ids): bool
    {
        if (empty($author_ids)) {
            return true;
        }

        try {
            foreach ($author_ids as $author_id) {
                $sql = "INSERT INTO book_authors (book_id, author_id) VALUES (?, ?)";
                $this->db->query($sql, [$book_id, $author_id]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("[Book::addAuthorsToBook] Ошибка добавления авторов книги: {$e->getMessage()} | ID книги: {$book_id}");
            throw $e;
        }
    }

    private function removeAllAuthorsFromBook($bookId): bool
    {
        try {
            $this->db->query("DELETE FROM book_authors WHERE book_id = ?", [$bookId]);
            return true;
        } catch (PDOException $e) {
            error_log("[Book::removeAllAuthorsFromBook] Ошибка удаления авторов книги: {$e->getMessage()} | ID книги: {$bookId}");
            throw $e;
        }
    }
}
