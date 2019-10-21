<?php

namespace core;

use dispatcher\Container;

class Router extends Container
{
    public $method;
    public $uri;
    public $path;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->path = $_SERVER['PATH_INFO'];

        require APP_PATH.'/app/routes.php';
    }

    //Router::get('/home','IndexController@getIndex');
    public function __call($method, $args)
    {
        if (empty($args[1])){
            Throw new \Exception('Too few args!');
        }

        $method = strtoupper($method);

        if ($this->path === $args[0] && $this->method === $method){
            if (is_object($args[1])){
                call_user_func($args[1]);
                exit();
            }

            $this->path ='/'.strtolower(str_replace(['Controller','get','@'],['','','/'],$args[1]));
            $this->uri = str_replace($args[0],$this->path,$this->uri);
        }
    }

    /**
     * 执行解析
     *
     */
    protected function start()
    {
        /**
         * 也可以写成 Config::get('default.route','querystring');
         *
         */
        $route = Config::get('default.route') ?? 'querystring';

        //解析 controller 和 action
        $path = explode('/',trim($this->path,'/'));

        if (empty($path[0])) {
            $path[0] = Config::get('default.controller','index');
        }
        $controller = ucfirst($path[0]).'Controller';

        //获取请求方法
        $method = strtolower($this->method);
        $action = $method.ucfirst($path[1] ?? Config::get('default.action','index'));

        //获取参数
        $args = [];
        if (method_exists($this,$route)) {
            $args = call_user_func_array([$this,$route],[$this->uri]);
        }    
        return ['controller'=>$controller,'action'=>$action,'args'=>$args];
    }
    /**
     * 查询字符串解析
     *
     */
    private function querystring($url)
    {
        $urls = explode('?', $url);
        
        if (empty($urls[1])) {
            return [];
        }
        $param_arr = [];
        $param_tmp = explode('&', $urls[1]);
        if (empty($param_tmp)) {
            return [];
        }
        foreach ($param_tmp as $param) {
            if (strpos($param, '=')) {
                list($key,$value) = explode('=', $param);
                //变量名是否复合规则
                if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key)) {
                    $param_arr[$key] = $value;
                }
            }
        }
        return $param_arr;
    }
    /**
     * 路径 url 解析
     *
     */
    private function restful($url)
    {
        $path = explode('/', trim(explode('?', $url)[0], '/'));
        $params = [];
        $i = 2;
        while (1) {
            if (!isset($path[$i])) {
                break;
            }
            $params[$path[$i]] = $path[$i+1] ?? '';
            $i = $i+2;
        }
        return $params;
    }
}
