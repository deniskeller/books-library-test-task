<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryMODELS\Author;

class AuthorController
{
    private Author $authorModel;

    public function __construct()
    {
        $this->authorModel = new Author();
    }

    public function index()
    {
        $authors = $this->authorModel->getAllAuthors();
        require VIEWS . '/pages/authors/index.php';
    }

    public function edit($id)
    {
        $author = $this->authorModel->getById($id);
        dump($author);

        if (!$author) {
            dump('authorNotFound');
            $_SESSION['error'] = 'Автор не найден';
            header('Location: ?action=authors');
            exit;
        }

        require VIEWS . '/pages/authors/edit.php';
    }
}