<?php

namespace BOOKSLibraryROUTING;

class RouteConfiguration
{
  public string $method;
  public string $uri;
  public string $controller;
  public string $action;
  public string $pattern;
  public array $params = [];
  public string $name;
  public array $middleware = [];

  public function __construct($method, $uri, $controller, $action)
  {
    $this->method = $method;
    $this->uri = $uri;
    $this->controller = $controller;
    $this->action = $action;
    $this->createPattern();
  }

  // вычислени и создание паттерна
  private function createPattern(): void
  {
    // получаем из ссылки все параметры
    preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $this->uri, $matches);
    // проверяем есть ли в массиве параметры без фигурных скобок. если нет, то возвращаем обычный URI
    if (!empty($matches[1])) {
      // если еть записываем в параметры
      $this->params = $matches[1];
      // заменяем все параметры на маску '([^/]+)'
      $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '([^/]+)', $this->uri);
      // dump($pattern);
      // обрамляем паттерн в "начало строкуи" и "конец строки"
      $this->pattern = '#^' . $pattern . '$#';
      // dump($this->pattern);
    } else {
      $this->pattern = '#^' . $this->uri . '$#';
    }
  }

  // проверка URI запроса на соответствие
  public function matches($requestUri): bool
  {
    return preg_match($this->pattern, $requestUri);
  }

  // извлекаем параметры из URI
  public function extractParams($requestUri)
  {
    if (empty($this->params)) {
      return [];
    }
    // извлекаем из URI первое соответсвие паттерну
    // dump($this->pattern);
    // dump($requestUri);
    preg_match($this->pattern, $requestUri, $matches);
    // dump($matches);
    // dump($this->params);

    // Удаляем полное совпадение (первый элемент)
    array_shift($matches);
    // dump($matches);

    // Создаем ассоциативный массив [имя_параметра => значение]
    $result = [];
    foreach ($this->params as $index => $paramName) {
      if (isset($matches[$index])) {
        $result[$paramName] = $matches[$index];
      }
    }
    // dump($result);
    return $result;
  }

  public function name(string $name): RouteConfiguration
  {
    $this->name = $name;
    return $this;
  }

  public function middleware(string $middleware): RouteConfiguration
  {
    $this->middleware[] = $middleware;
    return $this;
  }
}
