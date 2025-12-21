<?php

use database\Database;

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/database/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$database_config = require ROOT . '/config/database.php';
$connectionConfig = $database_config['connections']['mysql'];

$db = new Database($connectionConfig['driver'],
    $connectionConfig['host'],
    $connectionConfig['database'],
    $connectionConfig['charset'],
    $connectionConfig['username'],
    $connectionConfig['password']);

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
