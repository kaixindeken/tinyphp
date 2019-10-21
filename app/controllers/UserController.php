<?php

namespace controller;

use core\Controller;
use core\Model;
use http\Client\Response;
use model\User;
use core\Config;

class UserController extends Controller 
{
    public function getOne()
    {
        $res = User::find()->one();
        print_r($res);
    }

    public function getAll()
    {
        $res = User::find()->all();
        print_r($res);
    }


    public function getInfo()
    {
        $res1 = User::find()
            ->where(['<','age',16])
            ->and(['in','height',[165,170]])
            ->all();

        print_r($res1);
    }
}
