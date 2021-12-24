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

    public function actionPhpInfo()
    {
        echo phpinfo();
    }

    public function actionTest()
    {
        echo 'test';
    }

    public function actionTest1()
    {
        echo 'test1';
    }
}
