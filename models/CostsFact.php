<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "costsFact".
 *
 * @property string $id
 * @property double $total
 * @property string $user
 * @property integer $week
 * @property string $created
 */
class CostsFact extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                ],
            ],
        ];
    }

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
            [['week'], 'integer'],
            [['created'], 'safe'],
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
            'created' => 'Created',
        ];
    }

    public function newCost($total, $user = NULL)
    {
        $this->total = $total;
        $this->week = date('W');
        $this->user = $user;
        $this->save();
    }
}
