<?php

//header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: http://localhost:5173');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
//header('Access-Control-Allow-Headers: Content-Type');
//
//require_once '../utils/db_functions.php';
//
//// Если это предварительный запрос OPTIONS, просто завершаем его
//if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//    exit(0);
//}
//
//// Данные для подключения к базе
//$host = '127.0.1.23';
//$dbname = 'library';
//$username = 'root';
//$password = '';
//// Таблицы
//$authors_table = 'authors';
//$books_table = 'books';
//$authors_books_table = 'authors_books';
//
//
//try {
//    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//    $results = [];
//
//    $results['authors'] = createTableIfNotExists(
//        $pdo,
//        $authors_table,
//        "CREATE TABLE IF NOT EXISTS $authors_table (
//            id INT AUTO_INCREMENT PRIMARY KEY,
//            name VARCHAR(255) NOT NULL UNIQUE
//        )"
//    );
//
//    $results['books'] = createTableIfNotExists(
//        $pdo,
//        $books_table,
//        "CREATE TABLE IF NOT EXISTS $books_table (
//            id INT AUTO_INCREMENT PRIMARY KEY,
//            title VARCHAR(255) NOT NULL,
//            publication_year INT NOT NULL,
//            INDEX idx_year (publication_year)
//        )"
//    );
//
//    $results['authors_books'] = createTableIfNotExists(
//        $pdo,
//        $authors_books_table,
//        "CREATE TABLE IF NOT EXISTS $authors_books_table (
//            book_id INT NOT NULL,
//            author_id INT NOT NULL,
//            PRIMARY KEY (book_id, author_id),
//            FOREIGN KEY (book_id) REFERENCES $books_table(id) ON DELETE CASCADE,
//            FOREIGN KEY (author_id) REFERENCES $authors_table(id) ON DELETE CASCADE,
//            INDEX idx_author (author_id),
//            INDEX idx_book (book_id)
//        )"
//    );
//
//    // var_dump(value: $results);
//
//    $allSuccess = true;
//    foreach ($results as $result) {
//        // var_dump(value: $result);
//        if (!$result['success']) {
//            $allSuccess = false;
//            break;
//        }
//    }
//
//    if ($allSuccess) {
//        // echo json_encode([
//        //   'success' => true,
//        //   'message' => 'Все таблицы успешно созданы или уже существуют.',
//        //   'tables' => $results
//        // ]);
//    } else {
//        echo json_encode([
//            'success' => false,
//            'message' => 'Возникли проблемы при создании таблиц.',
//            'details' => $results
//        ]);
//    }
//} catch (PDOException $e) {
//    echo json_encode([
//        'success' => false,
//        'message' => 'Ошибка подключения к базе данных: ' . $e->getMessage()
//    ]);
//    exit();
//}


//class Database
//{
//  private  $host = '127.0.1.23';
//  private  $dbname = 'library';
//  private  $username = 'root';
//  private  $password = '';
//  private  $authors_table = 'authors';
//  private  $books_table = 'books';
//  private  $authors_books_table = 'authors_books';
//  public $pdo;
//
//  public function getConnection()
//
//  {
//    $this->pdo = null;
//  }
//}
