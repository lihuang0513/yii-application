<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class TestController extends Controller
{

    public function actionIndex()
    {
        echo 'index';
    }

    public function actionTest()
    {
        echo "Hello World";
    }

    public function actionGod()
    {
        echo "god";
    }

    public function actionPing()
    {
        echo "pong222";
    }
}
