<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseItem;

/**
 * PurchaseItemSearch represents the model behind the search form of `backend\models\PurchaseItem`.
 */
class PurchaseItemSearch extends PurchaseItem
{
    /**
     * {@inheritdoc}
     */
    public $purchase_date_search,$item_type,$item_category,$vendor_name,$item_name;
    public function rules()
    {
        return [
            [['item_no', 'purhcase_id', 'item_code', 'item_type', 'item_category'], 'integer'],
            [['net_value'], 'number'],
            [['item_image','purchase_date_search','item_type','item_category','vendor_name','item_name'], 'safe'],
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
    public function searchReport($params)
    {
        $query = PurchaseItem::find()->joinWith(['purhcase.vendor','item']);

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
        $purchase_date_format=( $this->purchase_date_search!='')?date('Y-m-d',strtotime( $this->purchase_date_search)):'';
        $query->andFilterWhere([
            'item_no' => $this->item_no,
            'purhcase_id' => $this->purhcase_id,
            'item_code' => $this->item_code,
            'net_value' => $this->net_value,
            'item_type' => $this->item_type,
            'item_category' => $this->item_category,
           // 'vendor_master.name' => $this->vendor_name,
            'purchase_header.status' => 0,
            'purchase_header.purchase_date' => $purchase_date_format,
            'item_master.type_id' => $this->item_type,
            'item_master.category_id' => $this->item_category,
        ]);

        $query->andFilterWhere(['like', 'item_image', $this->item_image]);
        $query->andFilterWhere(['like', 'vendor_master.name', $this->vendor_name]);
        $query->andFilterWhere(['like', 'item_master.name', $this->item_name]);

        return $dataProvider;
    }

        public function search($params)
    {
        $query = PurchaseItem::find();

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
            'item_no' => $this->item_no,
            'purhcase_id' => $this->purhcase_id,
            'item_code' => $this->item_code,
            'net_value' => $this->net_value,
            'item_type' => $this->item_type,
            'item_category' => $this->item_category,
        ]);

        $query->andFilterWhere(['like', 'item_image', $this->item_image]);

        return $dataProvider;
    }
}
