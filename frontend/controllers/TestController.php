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

    public function actionPing()
    {
        echo 'pong';
    }
}
