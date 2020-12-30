<?php
/**
 * xxd-server
 * @author amoydavid
 * Date: 2018/4/23
 * Time: 下午10:13
 */

namespace common\components;


class AssetManager extends \yii\web\AssetManager
{

    public function init()
    {
        clearstatcache(true);
        parent::init();
    }
}