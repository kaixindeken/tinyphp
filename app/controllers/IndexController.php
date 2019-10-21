<?php

namespace controller;

use core\Controller;
use core\Model;
use model\User;

class IndexController extends Controller 
{
    public function getIndex()
    {
        return 'get:index';
    }

    public function postIndex()
    {
        return 'post:index';
    }

    public function getOne()
    {
        return $this->renderFile('index');
    }

    public function getAll()
    {
        return $this->render('index');
    }

    public function postUser()
    {
        $res = User::find()
            ->select('id')
            ->where(['in','age',[12,15]])
            ->and(['>','weight',50])
            ->or(['like','name','%Wang'])
            ->all();
        return implode((array_column($res,'id')),'');
    }
}
