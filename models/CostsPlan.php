<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "costsPlan".
 *
 * @property string $id
 * @property double $totalCost
 * @property double $factCost
 * @property double $factBalance
 * @property integer $week
 * @property string $year
 * @property string $startWeek
 * @property string $endWeek
 */
class CostsPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'costsPlan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['totalCost', 'factCost', 'factBalance'], 'number'],
            [['week'], 'integer'],
            [['year', 'startWeek', 'endWeek'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'totalCost' => 'Total Cost',
            'factCost' => 'Fact Cost',
            'factBalance' => 'Fact Balance',
            'week' => 'Week',
            'year' => 'Year',
            'startWeek' => 'Start Week',
            'endWeek' => 'End Week',
        ];
    }
}
