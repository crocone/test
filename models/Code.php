<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 *
 * @property int $id
 * @property string $code
 * @property string $created_at
 *
 */
class Code extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%code}}';
    }

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['code'], 'filter', 'filter' => 'trim'],
            [['code'], 'required'],
            ['created_at', 'datetime']
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * Finds url by code.
     *
     * @param string $code
     * @return Code
     */
    public static function findByCode($code)
    {
        return static::findOne(['code' => $code]);
    }


    /**
     * @throws \yii\base\Exception
     */
    public function generateCode()
    {
        $this->code = Yii::$app->security->generateRandomString(rand(4, 12));
    }
}
