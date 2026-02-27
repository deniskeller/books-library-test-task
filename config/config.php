<?php

define("ROOT", dirname(__DIR__));
const CONFIG = ROOT . '/config';
const PUBLIC_HTML = ROOT . '/public';
const CORE = ROOT . '/core';
const APP = ROOT . '/app';
const ROUTING = ROOT . '/routing';
const CONTROLLERS = APP . '/Controllers';
const MODELS = APP . '/Models';
const VIEWS = APP . '/Views';
const COMPONENTS = VIEWS . '/components';
const PATH = 'https://library'; // для Open Server

// для Docker
// if (isset($_SERVER['HTTP_HOST'])) {
//   $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

//   define('PATH', $protocol . '://' . $_SERVER['HTTP_HOST']);
// } else {
//   define('PATH', 'http://localhost:8080');
// }

const HELPERS = ROOT . '/helpers';

require HELPERS . '/functions.php';
