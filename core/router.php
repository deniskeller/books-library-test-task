<?php

namespace BOOKSLibraryCORE;

class Router
{
    private const CONTROLLER_NAMESPACE = 'BOOKSLibraryCONTROLLERS\\';
    private array $routes = [];
    private $params = [];
    public function __construct()
    {
        $this->routes = require CONFIG . '/routes.php';
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
