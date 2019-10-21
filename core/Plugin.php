<?php

namespace core;

use dispatcher\Container;

abstract class Plugin extends Container
{
    abstract function routerStartup();
    abstract function routerShutdown();
}
