<?php

namespace BOOKSLibraryCORE;

use BOOKSLibraryROUTING\Route;

class App
{
  public static function run(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $_SESSION['previous_url'] = $_SESSION['current_url'] ?? '/';
      $_SESSION['current_url'] = $_SERVER['REQUEST_URI'];
    }

    $router = new Route();
    $router->dispatch();
  }
}
