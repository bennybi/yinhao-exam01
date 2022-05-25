<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\entity\Supplier as SupplierModel;

/**
 * Supplier represents the model behind the search form of `\common\models\entity\Supplier`.
 */
class Supplier extends SupplierModel {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'string'],
            [['name', 'code', 't_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = SupplierModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->id) {
            $query->andFilterWhere([$this->getOperator($this->id), 'id', $this->getOperatorVal($this->id)]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 't_status', $this->t_status]);

        return $dataProvider;
    }

    protected function getOperatorVal($qryString) {
        $operator = $this->getOperator($qryString);
        $val = str_replace($operator, '', $qryString);
        return $val;
    }

    protected function getOperator($qryString) {
        switch ($qryString) {
            case strpos($qryString, '>=') === 0:
                $operator = '>=';
                break;
            case strpos($qryString, '>') === 0:
                $operator = '>';
                break;
            case strpos($qryString, '<=') === 0:
                $operator = '<=';
                break;
            case strpos($qryString, '<') === 0:
                $operator = '<';
                break;
            case strpos($qryString, 'like') === 0:
                $operator = 'like';
                break;
            default:
                $operator = "=";
                break;
        }
        return $operator;
    }

}
