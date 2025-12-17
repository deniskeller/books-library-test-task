<?php
$start_app = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version >= 8');
}

require_once __DIR__ . '/../config/config.php';
require_once ROOT . '/vendor/autoload.php';


$uri = trim($_SERVER['REQUEST_URI'], '/');
//dd($uri);

if ($uri == '') {
    require_once CONTROLLERS . '/BooksController.php';
} elseif ($uri == 'authors') {
    require_once CONTROLLERS . '/AuthorsController.php';
} else {
    abort(404);
}

//dump("Time:" . microtime(true) - $start_app);
