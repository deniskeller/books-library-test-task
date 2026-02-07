<?php

namespace BOOKSLibraryROUTING;

use Exception;

class Route
{
    private const CONTROLLER_NAMESPACE = 'BOOKSLibraryCONTROLLERS\\';
    private static array $routes = [];

    public static function get(string $uri, array $controller): RouteConfiguration
    {
        return self::addRoute('GET', $uri, $controller);
    }
    public static function post(string $uri, array $controller): RouteConfiguration
    {
        return self::addRoute('POST', $uri, $controller);
    }
    public static function put(string $uri, array $controller): RouteConfiguration
    {
        return self::addRoute('PUT', $uri, $controller);
    }
    public static function delete(string $uri, array $controller): RouteConfiguration
    {
        return self::addRoute('DELETE', $uri, $controller);
    }

    private static function addRoute($method, $uri, $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($method, $uri, $controller[0], $controller[1]);
        self::$routes[] = $routeConfiguration;
        // dump($routeConfiguration);
        return $routeConfiguration;
    }

    public function dispatch()
    {
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
        // dump('REQUEST_URI ' . $requestUri);

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        // dump('REQUEST_METHOD ' . $requestMethod);
        // для PUT и DELETE форм
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach (self::$routes as $route) {
            if ($route->method === $requestMethod && $route->uri === $requestUri) {
                $controllerClass = $route->controller;
                $action = $route->action;

                if (!class_exists($controllerClass)) {
                    throw new Exception("Контроллер $controllerClass не существует");
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    throw new Exception("Метод $action не существует в $controllerClass");
                }

                dump($controller);

                return $controller->$action();
            }
        }

        abort(404);
    }
}
