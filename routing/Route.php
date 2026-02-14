<?php

namespace BOOKSLibraryROUTING;

use Exception;

class Route
{
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

    public static function redirect($url = '')
    {
        if ($url) {
            $redirect = $url;
        } else {
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
        }

        header("Location: {$redirect}");
        die;
    }

    public function dispatch()
    {
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // для PUT и DELETE форм
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach (self::$routes as $route) {
            if ($route->method === $requestMethod && $route->matches($requestUri)) {
                $controllerClass = $route->controller;
                $action = $route->action;
                $params = $route->extractParams($requestUri);
                // dump($params);

                dump($route);
                if (!empty($route->middleware)) {
                    $middleware = MIDDLEWARE[$route->middleware];
                    dump($middleware);
                }

                if (!class_exists($controllerClass)) {
                    // dump("Контроллер $controllerClass не существует");
                    throw new Exception("Контроллер $controllerClass не существует");
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    // dump("Метод $action не существует в $controllerClass");
                    throw new Exception("Метод $action не существует в $controllerClass");
                }

                // return $controller->$action($params);
                return call_user_func_array([$controller, $action], $params);
            }
        }

        abort(404);
    }
}
