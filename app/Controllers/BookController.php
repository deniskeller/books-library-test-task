<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\BookService;
use BOOKSLibraryCORE\FormFieldValidator;
use BOOKSLibraryMODELS\Author;
use BOOKSLibraryMODELS\Book;

class BookController
{
    public string $title = 'Страница книг';
    private Book $bookModel;
    private Author $authorModel;
    private BookService $bookService;
    public array $errors = [];
    public function __construct()
    {
        $this->bookModel = new Book();
        $this->authorModel = new Author();
        $this->bookService = new BookService();
    }

    // рендер страницы books
    public function index(): void
    {
        unset($_SESSION['errors'], $_SESSION['old_email'], $_SESSION['old_year'], $_SESSION['success']);

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
            $title = trim($_POST['title']) ?? '';
            $year = trim($_POST['year']) ?? '';
            $authors_ids = $_POST['authors_ids'] ?? [];
            // dump($_POST);

            // $formFields = ['title', 'year'];
            // $loadData = loadDataFormFields($formFields);

            // Валидация данных
            $errors = $this->bookService->validateBookData($_POST);

            // dump($_SESSION['errors']);
            // dd($errors);

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['data'] = $_POST;
                $_SESSION['old_title'] = $title;
                $_SESSION['old_year'] = $year;
                $_SESSION['old_year'] = $year;
                redirect('/books/create');
                // header('Location: /books/create');
                // exit;
            } else {
            }

            if ($this->bookModel->create($title, $year, $authors_ids)) {
                $_SESSION['success'] = 'Книга успешно добавлена';
                redirect('/books');
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
            $authors_ids = $_POST['authors_ids'] ?? [];

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
