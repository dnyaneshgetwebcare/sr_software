<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseHeader;

/**
 * PurchaseHeaderSearch represents the model behind the search form of `backend\models\PurchaseHeader`.
 */
class PurchaseHeaderSearch extends PurchaseHeader
{
    /**
     * {@inheritdoc}
     */
    public $vendor_name;
    public function rules()
    {
        return [
            [['id', 'vendor_id', 'location','status'], 'integer'],
            [['purchase_date','vendor_name'], 'safe'],
            [['purchase_amount', 'discount'], 'number'],
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
        $query = PurchaseHeader::find()->joinWith(['vendor']);;

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
//print_r($this->purchase_date);die;
        // grid filtering conditions
         $purchase_date_format=( $this->purchase_date!='')?date('Y-m-d',strtotime( $this->purchase_date)):'';
        $query->andFilterWhere([
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'purchase_date' => $purchase_date_format,
            'purchase_amount' => $this->purchase_amount,
            'discount' => $this->discount,
            'location' => $this->location,
            'purchase_header.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'vendor_master.name', $this->vendor_name]);
        return $dataProvider;
    }
}
