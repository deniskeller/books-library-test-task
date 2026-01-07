<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryMODELS\Author;
use BOOKSLibraryMODELS\Book;
use JetBrains\PhpStorm\NoReturn;

class BookController
{
    public string $title = 'Страница книг';
    private Book $bookModel;
    private Author $authorModel;

    public function __construct()
    {
        $this->bookModel = new Book();
        $this->authorModel = new Author();
    }

    // рендер страницы books
    public function index(): void
    {
        $title = $this->title;
        $authorFilter = $_GET['book-filter-author'] ?? null;
        $books = $this->bookModel->getAll((int)$authorFilter);
        $authors = $this->authorModel->getAll();

        require VIEWS . '/pages/books/index.php';
    }

    // рендер страницы редатирования книги
    public function edit($id): void
    {
        $book = $this->bookModel->getById($id);
        $authors = $this->authorModel->getAll();
        $selectedAuthorIds = [];

        if (!$book) {
            $_SESSION['error'] = 'Книга не найдена';
            header('Location: /books');
            exit;
        }

        foreach ($book['authors'] as $author) {
            $selectedAuthorIds[] = $author['id'];
        }

        require VIEWS . '/pages/books/edit.php';
    }

    // рендер страницы создания книги
    public function create(): void
    {
        $authors = $this->authorModel->getAll();
        require VIEWS . '/pages/books/edit.php';
    }

    // удаление книги
    #[NoReturn]
    public function destroy($id): void
    {
        if ($this->bookModel->deleteById($id)) {
            $_SESSION['success'] = 'Книга успешно удалена';
        } else {
            $_SESSION['error'] = 'Ошибка при удалении книги';
        }

        header('Location: /books');
        exit;
    }

    // запись новой книги в таблицу
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $year = trim($_POST['year']);
            $authors_ids = $_POST['$authors_ids'] ?? [];

            if (empty($title)) {
                $_SESSION['error'] = 'Название книги обязательно';
                header('Location: /books/create');
                exit;
            }

            if (empty($year)) {
                $_SESSION['error'] = 'Дата издания обязательно';
                header('Location: /books/create');
                exit;
            }

            if (empty($authors_ids)) {
                $_SESSION['error'] = 'Выберите одного или нескотльких авторов';
                header('Location: /books/create');
                exit;
            }

            if ($this->bookModel->create($title, $year, $authors_ids)) {
                $_SESSION['success'] = 'Книга успешно добавлена';
                header('Location: /books');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при добавлении книги';
            }
        }
    }

    public function update($id): void
    {
//        dump('update');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $year = trim($_POST['year']);
            $authors_ids = $_POST['$authors_ids'] ?? [];

            if (empty($title)) {
                $_SESSION['error'] = 'Название книги обязательно';
                header('Location: /books/edit?id=' . $id);
                exit;
            }

            if (empty($year)) {
                $_SESSION['error'] = 'Дата издания обязательно';
                header('Location: /books/edit?id=' . $id);
                exit;
            }

            if (empty($authors_ids)) {
                $_SESSION['error'] = 'Выберите одного или нескотльких авторов';
                header('Location: /books/edit?id=' . $id);
                exit;
            }

            if ($this->bookModel->update($id, $title, $year, $authors_ids)) {
                $_SESSION['success'] = 'Книга успешно отредактирована';
                header('Location: /books');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при обновлении книги';
            }
        }
    }
}

