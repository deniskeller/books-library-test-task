<?php

//class Router
//{
//}


$uri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');


if (array_key_exists($uri, $routes)) {
    if (file_exists(CONTROLLERS . "/" . $routes[$uri])) {
        require_once CONTROLLERS . "/" . $routes[$uri];
    } else {
        abort(404);
    }
} else {
    abort(404);
}