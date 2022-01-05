<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Products extends ActiveRecord

{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }


    public static function getProductById($id)
    {
        return static::findOne(['id' => $id]);
    }

}
