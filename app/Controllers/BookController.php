<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryMODELS\Book;
use JetBrains\PhpStorm\NoReturn;

class BookController
{
    public string $title = 'Страница книг';
    private Book $bookModel;

    public function __construct()
    {
        $this->bookModel = new Book();
    }

    public function index(): void
    {
        $title = $this->title;
        $books = $this->bookModel->getAll();
        require VIEWS . '/pages/books/index.php';
    }

    public function edit($id): void
    {
        $book = $this->bookModel->getById($id);

        if (!$book) {
            $_SESSION['error'] = 'Книга не найдена';
            header('Location: /books');
            exit;
        }

        require VIEWS . '/pages/books/edit.php';
    }

    public function create(): void
    {
        require VIEWS . '/pages/books/edit.php';
    }

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

    public function store(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $year = trim($_POST['year']);

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

            if ($this->bookModel->create($title, $year)) {
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $year = trim($_POST['year']);

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

            if ($this->bookModel->update($id, $title, $year)) {
                $_SESSION['success'] = 'Книга успешно добавлена';
                header('Location: /books');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при обновлении книги';
            }
        }
    }
}

