<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\AuthorService;
use BOOKSLibraryCORE\View;
use BOOKSLibraryMODELS\Author;
use BOOKSLibraryROUTING\Route;

class AuthorController
{
    public string $title = 'Страница авторов';
    private Author $authorModel;
    private AuthorService $authorService;

    public function __construct()
    {
        $this->authorModel = new Author();
        $this->authorService = new AuthorService();
    }

    public function index(): void
    {
        unset($_SESSION['errors'], $_SESSION['old_data']);

        $title = $this->title;
        $authors = $this->authorModel->getAll();
        if (!is_array($authors)) {
            $_SESSION['error'] = 'Не удалось загрузить список авторов';
        }
        // require VIEWS . '/pages/authors/index.php';
        View::render('authors.index', compact('title', 'authors'));
    }

    public function edit($id): void
    {
        $author = $this->authorModel->getById($id);

        if (!$author) {
            $_SESSION['error'] = 'Автор не найден';
            Route::redirect('/authors');
        }

        // require VIEWS . '/pages/authors/edit.php';
        View::render('authors.edit', compact('author'));
    }

    public function create(): void
    {
        // require VIEWS . '/pages/authors/edit.php';
        View::render('authors.edit');
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);

            // Валидация данных
            $errors = $this->authorService->validateAuthorData($_POST);

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                Route::redirect('/authors/create');
            }

            if ($this->authorModel->create($name)) {
                unset($_SESSION['old_data']);
                unset($_SESSION['errors']);

                $_SESSION['success'] = 'Автор успешно добавлен';
                Route::redirect('/authors');
            } else {
                $_SESSION['error'] = 'Ошибка при добавлении автора';
                Route::redirect('/authors/create');
            }
        }
    }

    public function update($id): void
    {
        $name = trim($_POST['name']);

        // Валидация данных
        $errors = $this->authorService->validateAuthorData($_POST);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            Route::redirect("/authors/{$id}/edit");
        }

        if ($this->authorModel->update($id, $name)) {
            unset($_SESSION['old_data']);
            unset($_SESSION['errors']);
            $_SESSION['success'] = 'Автор успешно обновлен';

            Route::redirect("/authors");
        } else {
            $_SESSION['error'] = 'Ошибка при обновлении автора';
            Route::redirect("/authors/{$id}/edit");
        }
    }

    public function destroy($id): void
    {
        if ($this->authorModel->deleteById($id)) {
            $_SESSION['success'] = 'Автор успешно удален';
        } else {
            $_SESSION['error'] = 'Ошибка при удалении автора';
        }

        Route::redirect('/authors');
    }
}
