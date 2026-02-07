<?php

namespace BOOKSLibraryROUTING;

class Route
{
    private const CONTROLLER_NAMESPACE = 'BOOKSLibraryCONTROLLERS\\';
    private static array $routes = [];
    private $params = [];
    public function __construct()
    {
        $this->routes = require ROUTING . '/routes.php';
    }

    public static function get(string $route, array $controller)
    {
        echo 'get method';
    }

    public function dispatch()
    {
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
        // dump($requestUri);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // для PUT и DELETE форм
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $key => $route) {
            // dump($route);
        }
    }
}
