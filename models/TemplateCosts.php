<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templateCosts".
 *
 * @property string $id
 * @property double $total
 * @property string $name
 */
class TemplateCosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'templateCosts';
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
