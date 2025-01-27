<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CustomerMaster;

/**
 * CustomerMasterSearch represents the model behind the search form of `backend\models\CustomerMaster`.
 */
class CustomerMasterSearch extends CustomerMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'email_id', 'contact_nos', 'contact_nos_2', 'address', 'reference', 'reference_name', 'created_date', 'cust_group'], 'safe'],
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
        $query = CustomerMaster::find();

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
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email_id', $this->email_id])
            ->andFilterWhere(['like', 'contact_nos', $this->contact_nos])
            ->andFilterWhere(['like', 'contact_nos_2', $this->contact_nos_2])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'reference_name', $this->reference_name])
            ->andFilterWhere(['like', 'cust_group', $this->cust_group]);

        return $dataProvider;
    }
}
