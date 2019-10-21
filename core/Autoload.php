<?php

/**
 * key 表示 namespace
 * value 表示路径
 *
 */
$path = [
    'core' => 'core',
    'app' => 'app',
    'controller' => 'app/controllers',
    'model' => 'app/models',
    'view' => 'app/views',
    'plugin' => 'app/plugins',
    'dispatcher' => 'core/dispatcher',
];

spl_autoload_register(function($class) use ($path) {
    $position = strripos($class,'\\');

    $key = substr($class,0,$position);
    $value = $path[$key] ?? '';

    $file = substr($class,$position+1).'.php';
    
    include APP_PATH.'/'.$value.'/'.$file;
});

