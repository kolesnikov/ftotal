<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property string $id
 * @property double $total
 * @property string $name
 * @property string $type
 * @property integer $date
 */
class Plan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'number'],
            [['type'], 'string'],
            [['date'], 'integer'],
            [['name'], 'string', 'max' => 200]
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
            'name' => 'Name',
            'type' => 'Type',
            'date' => 'Date',
        ];
    }
}
