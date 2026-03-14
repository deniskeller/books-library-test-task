<?php
session_start();

$start_app = microtime(true);

use BOOKSLibraryCORE\App;

require __DIR__ . '/../config/config.php';
require ROOT . '/vendor/autoload.php';
require ROOT . '/database/Database.php';
require ROUTING . '/web.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new App();
$app->run();

//dump("Time:" . microtime(true) - $start_app);
