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

    public function store($name): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);

            if (empty($name)) {
                $_SESSION['error'] = 'ФИО автора обязательно';
                header('Location: /books/create');
                exit;
            }

            if ($this->bookModel->create($name)) {
                $_SESSION['success'] = 'Автор успешно добавлен';
                header('Location: /books');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при добавлении автора';
            }
        }
    }

    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);

            if (empty($name)) {
                $_SESSION['error'] = 'ФИО автора обязательно';
                header('Location: /authors/edit?id=' . $id);
                exit;
            }

            if ($this->bookModel->update($id, $name)) {
                $_SESSION['success'] = 'Автор успешно обновлен';
                header('Location: /authors');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при обновлении автора';
            }
        }
    }
}

