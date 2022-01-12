<?php

namespace frontend\controllers;

use common\models\ProductGet;
use common\models\Products;
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

    public function actionOrder()
    {

//        if($t = \Yii::$app->redis->rpop('stock')){
//            file_put_contents('text', $t . PHP_EOL, FILE_APPEND);
//        }
//        die;
//
//        for ($i = 0; $i <= 100; $i++) {
//            \Yii::$app->redis->lpush('stock', $i);
//        }
//        die;

        $tran = \Yii::$app->db->beginTransaction();
        try {
            $sql = "select * from " . Products::tableName() . " where id = 1 for update";
            $product = Products::findBySql($sql)->one();
            if (empty($product)) {
                echo "暂无库存";
                return;
            }

//            file_put_contents('text', $product->stock . PHP_EOL, FILE_APPEND);

            $product->stock = $product->stock - 1;
            $result = $product->save();

            $tran->commit();

            var_dump($result);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
