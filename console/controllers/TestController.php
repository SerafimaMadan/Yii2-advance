<?php

namespace console\controllers;


use yii\console\Controller;

class TestController extends Controller
{
    /**
     * Output param
     * @param $param
     */
    public function actionIndex($param)
    {
        echo '$param='.$param ;
    }
}