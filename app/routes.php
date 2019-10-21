<?php

use core\Config;
use core\Router;


Router::get('/phpinfo',function(){
    return Config::get('default');
});

Router::get('/home','IndexController@getIndex');

Router::post('/user/update','IndexController@postIndex');
