<?php

$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require __DIR__ . '/../config/config.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/database/Database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

//РОУТИНГ
require CONTROLLERS . '/AuthorController.php';
require CONTROLLERS . '/BookController.php';


$url = $_GET['url'] ?? 'books';
$url = trim($url, '/');
$parts = explode('/', $url);

$controllerMap = [
    'authors' => 'AuthorController',
    'books' => 'BookController',
];

$controllerName = $controllerMap[$parts[0]] ?? 'BookController';
$method = $parts[1] ?? 'index';
$params = array_slice($parts, 2);

$controllerClass = 'BOOKSLibraryCONTROLLERS\\' . $controllerName;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    call_user_func_array([$controller, $method], $params);
} else {
    echo "Контроллер не найден";
}

//dump("Time:" . microtime(true) - $start_app);