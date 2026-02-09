<?php

namespace BOOKSLibraryCONTROLLERS;

use BOOKSLibraryCORE\BookService;
use BOOKSLibraryMODELS\Author;
use BOOKSLibraryMODELS\Book;
use BOOKSLibraryROUTING\Route;
use Exception;

class BookController
{
    public string $title = 'Страница книг';
    private Book $bookModel;
    private Author $authorModel;
    private BookService $bookService;
    // public array $errors = [];
    public function __construct()
    {
        $this->bookModel = new Book();
        $this->bookService = new BookService();
        $this->authorModel = new Author();
    }

    // рендер страницы books
    public function index(): void
    {
        unset($_SESSION['errors'], $_SESSION['old_data']);

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
            Route::redirect('/books');
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
        $response = $this->bookModel->deleteById($id);

        if ($response) {
            $_SESSION['success'] = 'Книга успешно удалена';
        } else {
            $_SESSION['error'] = 'Ошибка при удалении книги';
        }
        Route::redirect('/');
    }

    // запись новой книги в таблицу
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']) ?? '';
            $year = trim($_POST['year']) ?? '';
            $authors_ids = $_POST['authors_ids'] ?? [];

            // $formFields = ['title', 'year'];
            // $loadData = loadDataFormFields($formFields);

            // Валидация данных
            $errors = $this->bookService->validateBookData($_POST);

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                Route::redirect('/books/create');
            }

            $response = $this->bookModel->create($title, $year, $authors_ids);

            if ($response) {
                unset($_SESSION['old_data']);
                unset($_SESSION['errors']);

                $_SESSION['success'] = 'Книга успешно добавлена';
                Route::redirect('/');
            } else {
                $_SESSION['error'] = 'Ошибка при добавлении книги';
                Route::redirect('/books/create');
            }
        }
    }

    // редактирование пданных книги
    public function update($id): void
    {
        $title = trim($_POST['title']);
        $year = trim($_POST['year']);
        $authors_ids = $_POST['authors_ids'] ?? [];

        // Валидация данных
        $errors = $this->bookService->validateBookData($_POST);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            $_SESSION['old_data']['id'] = $id;
            $_SESSION['old_data']['authors_ids'] = $authors_ids;

            Route::redirect("/books/{$id}/edit");
        }

        if ($this->bookModel->update($id, $title, $year, $authors_ids)) {
            unset($_SESSION['old_data']);
            unset($_SESSION['errors']);

            $_SESSION['success'] = 'Книга успешно отредактирована';
            Route::redirect('/');
        } else {
            $_SESSION['error'] = 'Ошибка при обновлении книги';
            Route::redirect("/books/{$id}/edit");
        }
    }

    public function show($id, $category = 'post')
    {
        echo 'id: ' . $id . '<br>' . 'category: ' . $category;
    }
}
