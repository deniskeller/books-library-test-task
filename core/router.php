<?php

namespace BOOKSLibraryCORE;
// require_once CONFIG . '/routes.php';


// $uri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');


// if (array_key_exists($uri, $routes)) {
//     if (file_exists(CONTROLLERS . "/" . $routes[$uri])) {
//         require_once CONTROLLERS . "/" . $routes[$uri];
//     } else {
//         abort(404);
//     }
// } else {
//     abort(404);
// }

class Router
{
    private $routes = [];
    private $params = [];
    public function __construct()
    {
        $this->routes = require CONFIG . '/routes.php';
    }

    public function dispatch()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
        dump($uri);

        $method = $_SERVER['REQUEST_METHOD'];
        dump($method);
    }
}
