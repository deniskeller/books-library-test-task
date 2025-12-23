<?php

use database\Database;

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/database/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$database_config = require ROOT . '/config/database.php';
$connectionConfig = $database_config['connections']['mysql'];

$db = new Database($connectionConfig['driver'],
    $connectionConfig['host'],
    $connectionConfig['database'],
    $connectionConfig['charset'],
    $connectionConfig['username'],
    $connectionConfig['password'],
    $connectionConfig['options']);

$connection = $db->connect();

dump($connection);

try {
    $db->insert('authors', [
        'name' => 'Лермонтов Михаил Юрьевич',
    ]);

} catch (PDOException $e) {
    echo "Ошибка базы данных: " . $e->getMessage();
}

//dump("Time:" . microtime(true) - $start_app);
