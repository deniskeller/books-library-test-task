<?php

use BOOKSLibraryCORE\Router;

session_start();

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

//dump(parse_url($_SERVER['REQUEST_URI']));
$url = $_GET['url'] ?? 'books';
//dump($url);
$id = $_GET['id'] ?? null;
//dump($id);
$url = trim($url, '/');
//dump($url);
$parts = explode('/', $url);
//dump($parts);

$controllerMap = [
    'authors' => 'AuthorController',
    'books' => 'BookController',
];

$controllerName = $controllerMap[$parts[0]] ?? 'BookController';
//dump($controllerName);
$method = $parts[1] ?? 'index';
//dump($method);
$params = array_slice($parts, 2);
//dump($params);

$controllerClass = 'BOOKSLibraryCONTROLLERS\\' . $controllerName;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    call_user_func_array([$controller, $method], [$id]);
} else {
    echo "Контроллер не найден";
}

//dump("Time:" . microtime(true) - $start_app);

$router = new Router();
$router->dispatch();
