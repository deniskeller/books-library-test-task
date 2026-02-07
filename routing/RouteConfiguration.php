<?php

namespace BOOKSLibraryROUTING;

class RouteConfiguration
{
  public string $route;
  public string $controller;
  public string $action;
  public string $name;
  public string $middleware;

  public function __construct($route, $controller, $action)
  {
    $this->route = $route;
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
