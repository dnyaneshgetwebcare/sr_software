<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ItemMaster;

/**
 * ItemMasterSearch represents the model behind the search form of `backend\models\ItemMaster`.
 */
class ItemMasterSearch extends ItemMaster
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'category_id', 'vendor_id', 'rent_times', 'colour_cat', 'nos_dry_cleaning'], 'integer'],
            [['item_code', 'name', 'details', 'size', 'purchase_date', 'scrab_status', 'item_status'], 'safe'],
            [['purchase_amount', 'rent_amount', 'deposit_amount', 'expense_amount'], 'number'],
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
        $query = ItemMaster::find();

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
            'type_id' => $this->type_id,
            'category_id' => $this->category_id,
            'purchase_date' => $this->purchase_date,
            'purchase_amount' => $this->purchase_amount,
            'rent_amount' => $this->rent_amount,
            'deposit_amount' => $this->deposit_amount,
            'vendor_id' => $this->vendor_id,
            'rent_times' => $this->rent_times,
            'expense_amount' => $this->expense_amount,
            'colour_cat' => $this->colour_cat,
            'nos_dry_cleaning' => $this->nos_dry_cleaning,
            'delete_status' => $this->delete_status,
        ]);
        $query->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'scrab_status', $this->scrab_status])
            ->andFilterWhere(['like', 'item_status', $this->item_status]);

        return $dataProvider;
    }
}
