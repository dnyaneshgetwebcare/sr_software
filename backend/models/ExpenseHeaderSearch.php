<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ExpenseHeader;

/**
 * ExpenseHeaderSearch represents the model behind the search form of `backend\models\ExpenseHeader`.
 */
class ExpenseHeaderSearch extends ExpenseHeader
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'expense_type', 'vendor_id', 'delete_status'], 'integer'],
            [['expense_date', 'remark', 'image_url', 'name', 'contact_nos', 'address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = ExpenseHeader::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'expense_date' => $this->expense_date,
            'expense_type' => $this->expense_type,
            'vendor_id' => $this->vendor_id,
            'delete_status' => $this->delete_status,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'image_url', $this->image_url])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'contact_nos', $this->contact_nos])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
