<?php

use JetBrains\PhpStorm\NoReturn;

function dump_v($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}


#[NoReturn]
function dd_v($data): void
{
    dump_v($data);
    die;
}


#[NoReturn]
function abort($code = 400): void
{
    http_response_code($code);
    require VIEWS . '/errors/' . $code . '.php';
    die;
}

function print_array($array): void
{
    echo '<pre>' . print_r($array, true) . '</pre>';
}
