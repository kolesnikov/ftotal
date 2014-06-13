<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planMonth".
 *
 * @property string $id
 * @property double $totalProfit
 * @property double $totalCosts
 * @property double $dayCost
 * @property string $date
 */
class PlanMonth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planMonth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['totalProfit', 'totalCosts', 'dayCost', 'date'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'totalProfit' => 'Total Profit',
            'totalCosts' => 'Total Costs',
            'dayCost' => 'Day Cost',
            'date' => 'Date',
        ];
    }
}
