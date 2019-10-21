<?php

namespace core;

use dispatcher\Container;

class Application extends Container
{
    public $boot;
    /**
     * 初始化Bootstrap
     *
     */
    public function __construct()
    {
        $this->boot = \app\Bootstrap::register();
    }

    /**
     * 加载启动项
     * 执行插件
     * 路由解析
     * 调用控制器方法
     * 输出内容
     */
    public function run()
    {
        //该类中所有以init开头的方法都会被调用
        $funcs = array_filter(get_class_methods($this->boot),[$this,'getBootFuncs']);
        foreach($funcs as $func) {
            \app\Bootstrap::call($func);
        }

        //路由解析
        $router = Router::start();
        $controller = "controller\\".$router['controller'];
        $action = $router['action'];
        $args = $router['args'];

        echo $controller::call($action,$args);
    }

    private function getBootFuncs($func)
    {
        return 0 === strpos($func, 'init') ? 1 : 0;
    }

}
