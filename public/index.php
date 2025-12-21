<?php

use database\Database;

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require_once __DIR__ . '/../config/config.php';
require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/database/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$driver = $_ENV['DB_DRIVER'];
$host = $_ENV['DB_HOST'];
$database = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

$db = new Database($driver, $host, $database, 'utf8mb4', $username);
dump($db);

//try {
//    $db->insert('users', [
//        'name' => 'John Doe',
//        'email' => 'john@example.com',
//        'age' => 30
//    ]);
//
//} catch (PDOException $e) {
//    echo "Ошибка базы данных: " . $e->getMessage();
//}

//dump("Time:" . microtime(true) - $start_app);
