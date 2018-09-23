<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class TestController extends Controller
{
    public function actionIndex(){
        return $this->render('index', [

        ]);
      \Yii::setAlias('@about', Url::to('site/about'));
      return Url::to('@about');
     return VarDumper::dumpAsString(\yii::$aliases, 10, true);
    }
}