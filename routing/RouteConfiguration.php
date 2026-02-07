<?php

namespace BOOKSLibraryROUTING;

class RouteConfiguration
{
  public string $method;
  public string $uri;
  public string $controller;
  public string $action;
  public string $name;
  public string $middleware;

  public function __construct($method, $uri, $controller, $action)
  {
    $this->method = $method;
    $this->uri = $uri;
    $this->controller = $controller;
    $this->action = $action;
  }

  public function name(string $name): RouteConfiguration
  {
    $this->name = $name;
    return $this;
  }

  public function middleware(string $middleware): RouteConfiguration
  {
    $this->middleware = $middleware;
    return $this;
  }
}
