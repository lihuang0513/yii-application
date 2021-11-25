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
        echo "Hello World123";
    }

    public function actionGod()
    {
        echo "god";
    }

}
