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

    public function actionHoney()
    {
        $this->layout = false;
        return $this->render('honey');
    }

    public function actionJy()
    {
        $this->layout = false;
        return $this->render('jy');
    }

    public function actionTest1()
    {
        echo 'test1';
    }
}
