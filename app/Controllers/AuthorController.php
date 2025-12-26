<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryMODELS\Author;
use JetBrains\PhpStorm\NoReturn;

class AuthorController
{
    public string $title = 'Страница авторов';
    private Author $authorModel;

    public function __construct()
    {
        $this->authorModel = new Author();
    }

    public function index(): void
    {
        $title = $this->title;
        $authors = $this->authorModel->getAll();
        require VIEWS . '/pages/authors/index.php';
    }

    public function edit($id): void
    {
        $author = $this->authorModel->getById($id);

        if (!$author) {
            $_SESSION['error'] = 'Автор не найден';
            header('Location: /authors');
            exit;
        }

        require VIEWS . '/pages/authors/edit.php';
    }

    public function create(): void
    {
        require VIEWS . '/pages/authors/edit.php';
    }

    public function store($name): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);

            if (empty($name)) {
                $_SESSION['error'] = 'ФИО автора обязательно';
                header('Location: /authors/create');
                exit;
            }

            if ($this->authorModel->create($name)) {
                $_SESSION['success'] = 'Автор успешно добавлен';
                header('Location: /authors');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при добавлении автора';
            }
        }
    }

    #[NoReturn]
    public function destroy($id): void
    {
        if ($this->authorModel->deleteById($id)) {
            $_SESSION['success'] = 'Автор успешно удален';
        } else {
            $_SESSION['error'] = 'Ошибка при удалении автора';
        }

        header('Location: /authors');
        exit;
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

            if ($this->authorModel->update($id, $name)) {
                $_SESSION['success'] = 'Автор успешно обновлен';
                header('Location: /authors');
                exit;
            } else {
                $_SESSION['error'] = 'Ошибка при обновлении автора';
            }
        }
    }
}