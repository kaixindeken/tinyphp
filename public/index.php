<?php

use \core\Application;

define('APP_PATH',dirname(__DIR__));

require APP_PATH.'/core/Autoload.php';

Application::register()->run();
