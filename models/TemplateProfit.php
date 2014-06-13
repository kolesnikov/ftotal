<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templateProfit".
 *
 * @property string $id
 * @property double $total
 * @property string $name
 */
class TemplateProfit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'templateProfit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total'], 'number'],
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
        ];
    }
}
