<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class TestController extends Controller
{
    public function actionTest()
    {
        echo "Hello World";
    }

    public function actionSay()
    {
        echo "my name is zhang";
    }
}
