<?php

define("ROOT", dirname(__DIR__));
//define("PUBLIC", ROOT . '/public');
//define("CORE", ROOT . '/core');
//define("APP", ROOT . '/app');
//define("CONTROLLERS", APP . '/controllers');
//define("MODELS", APP . '/models');
//define("VIEWS", APP . '/views');
//define("PATH", 'https://library');
const CONFIG = ROOT . '/config';
const PUBLIC_HTML = ROOT . '/public';
const CORE = ROOT . '/core';
const APP = ROOT . '/app';
const CONTROLLERS = APP . '/controllers';
const MODELS = APP . '/models';
const VIEWS = APP . '/views';
const COMPONENTS = VIEWS . '/components';
const PATH = 'https://library';
const HELPERS = ROOT . '/helpers';

require_once HELPERS . '/functions.php';
