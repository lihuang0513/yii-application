<?php


namespace backend\controllers;


use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class GoodsController extends Controller
{

    public function actionTest()
    {

        $sql = "select * from goods_stock where goods_id = 1";
        $command = Yii::$app->db->createCommand($sql);
        $goods_stock = $command->queryOne();

        if($goods_stock['stock'] > 0){
            $sql = "update goods_stock set stock = stock - 1 where goods_id = 1";
            $command = Yii::$app->db->createCommand($sql);
            $result = $command->execute();
            echo '更新goods_id=1结果==》'.$result;
        }else{
            echo '抢完了哦';
        }
    }

    //悲观锁s
    public function actionTest1()
    {
        $tran = Yii::$app->db->beginTransaction();
        $sql = "select * from goods_stock where goods_id = 1 for update";
        $command = Yii::$app->db->createCommand($sql);
        $goods_stock = $command->queryOne();

        if($goods_stock['stock'] > 0){
            $sql = "update goods_stock set stock = stock - 1 where goods_id = 1";
            $command = Yii::$app->db->createCommand($sql);
            $result = $command->execute();
            echo '更新goods_id=1结果==》'.$result;
        }else{
            echo '抢完了哦';
        }
        $tran->commit();
    }

    //乐观锁
    public function actionTest2()
    {
        $tran = Yii::$app->db->beginTransaction();
        try {
            $sql = "select * from goods_stock where goods_id = 1";
            $command = Yii::$app->db->createCommand($sql);
            $goods_stock = $command->queryOne();

            if ($goods_stock['stock'] > 0) {
                $sql = "update goods_stock set stock = stock - 1,version = version + 1 where goods_id = 1 and version = :version";
                $command = Yii::$app->db->createCommand($sql, [
                    ':version' => $goods_stock['version']
                ]);
                $result = $command->execute();
                echo '更新goods_id=1结果==》' . $result;
            } else {
                echo '抢完了哦';
            }
            $tran->commit();
        }catch (\Exception $e){
            file_put_contents('log.txt',$e->getMessage());
        }
    }

    public function actionInitStock()
    {
        try{
            $redis = Yii::$app->redis;

            $sql = "select * from goods_stock where goods_id = 1";
            $command = Yii::$app->db->createCommand($sql);
            $goods_stock = $command->queryOne();

            $cache_key = 'goods_id_1';
            for($i=0;$i<$goods_stock['stock'];$i++){
                $redis->lpush($cache_key,1);
            }
        }catch (\Exception $e){
            echo $e->getMessage()."\n";
        }

    }

    //文件锁

    //redis lpush
    public function actionTest4()
    {
        $tran = Yii::$app->db->beginTransaction();
        try {

            $redis = Yii::$app->redis;
            $cache_key = 'goods_id_1';
            if(!$redis->rpop($cache_key)){
                throw new \Exception('当前秒杀人数太多啦～');
            }

            $sql = "update goods_stock set stock = stock - 1 where goods_id = 1";
            $command = Yii::$app->db->createCommand($sql);
            $result = $command->execute();
            echo '更新goods_id=1结果==》'.$result;

            $tran->commit();
        }catch (\Exception $e){
            var_dump($e->getMessage());die();
            file_put_contents('log.txt',$e->getMessage());
        }
    }

    public function actionTest5()
    {
        $tran = Yii::$app->db->beginTransaction();
        try {

//            $ok = $redis->set($key, $random, array('nx', 'ex' => $ttl));
//
//            if ($ok) {
//                $cache->update();
//
//                if ($redis->get($key) == $random) {
//                    $redis->del($key);
//                }
//            }

            $redis = Yii::$app->redis;
            $cache_key = 'goods_id_1';
            $uni = uniqid();

            $bool = $redis->setnx($cache_key, $uni);
            $redis->expire($cache_key,10);
            if(!$bool) { // 获取锁权限
                throw new \Exception('当前秒杀人数太多啦～');
            }

            // 程序逻辑处理：
            $sql = "select * from goods_stock where goods_id = 1";
            $command = Yii::$app->db->createCommand($sql);
            $goods_stock = $command->queryOne();

            if ($goods_stock['stock'] > 0) {
                $sql = "update goods_stock set stock = stock - 1 where goods_id = 1";
                $command = Yii::$app->db->createCommand($sql);
                $result = $command->execute();
                echo '更新goods_id=1结果==》' . $result;
                if (!$result) {
                    // 释放锁
                    throw new \Exception('更新库存失败');
                }
            }

            $tran->commit();
        }catch (\Exception $e){
            file_put_contents('log.txt',$e->getMessage().PHP_EOL,FILE_APPEND);
        } finally {
            // 防止死锁
            file_put_contents('finally.txt','finally'.PHP_EOL,FILE_APPEND);
            if($uni == $redis->get($cache_key)){
                $redis->del($cache_key);
            }
        }
    }

    //redis lua
}