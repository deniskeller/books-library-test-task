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
const PATH = 'https://library';
const HELPERS = ROOT . '/helpers';

require HELPERS . '/functions.php';
