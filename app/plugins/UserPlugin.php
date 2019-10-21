<?php

namespace plugin;

use core\Plugin;
use core\Config;

class UserPlugin extends Plugin
{
    public function routerStartup()
    {
        echo "User : startup".PHP_EOL;
    }

    public function routerShutdown()
    {
        echo "User : shutdown".PHP_EOL;
    }
}
