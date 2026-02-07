<?php

namespace BOOKSLibraryROUTING;

class Route
{
    private const CONTROLLER_NAMESPACE = 'BOOKSLibraryCONTROLLERS\\';
    private static array $routes = [];

    public static function get(string $route, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routes[] = $routeConfiguration;
        // dump($routeConfiguration);
        return $routeConfiguration;
    }

    private static function addRoute($route, $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($route, $controller[0], $controller[1]);
        self::$routes[] = $routeConfiguration;
        // dump($routeConfiguration);
        return $routeConfiguration;
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
    }
}
