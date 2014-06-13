<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "costsFact".
 *
 * @property string $id
 * @property double $total
 * @property string $user
 * @property integer $week
 * @property integer $day
 */
class CostsFact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'costsFact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'number'],
            [['week', 'day'], 'integer'],
            [['user'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total' => 'Total',
            'user' => 'User',
            'week' => 'Week',
            'day' => 'Day',
        ];
    }
}
