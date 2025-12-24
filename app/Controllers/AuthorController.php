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

}