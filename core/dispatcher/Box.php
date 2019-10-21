<?php 

namespace dispatcher;

class Box extends Dispatcher
{
    protected function getInstance()
    {
        return self::newObject();
    }
}
