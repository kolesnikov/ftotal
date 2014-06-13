<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TemplateProfit as TemplateProfitModel;

/**
 * TemplateProfit represents the model behind the search form about `app\models\TemplateProfit`.
 */
class TemplateProfit extends TemplateProfitModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['total'], 'number'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TemplateProfitModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
