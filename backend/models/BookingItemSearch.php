<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BookingItem;
use yii\data\ArrayDataProvider;


/**
 * BookingItemSearch represents the model behind the search form of `backend\models\BookingItem`.
 */
class BookingItemSearch extends BookingItem
{
    /**
     * {@inheritdoc}
     */
    public $item_name, $category_id, $type_id, $date, $customer_name, $view_level, $from_date, $to_date, $rented_time;

    public function rules()
    {
        return [
            [['item_id', 'booking_id', 'item_no', 'product_id', 'item_type', 'item_category', 'discount', 'deposite_charge_status', 'payment_status'], 'integer'],
            [['description', 'image_name', 'pickup_date', 'picked_date', 'return_date', 'returned_date', 'item_status', 'note', 'deposite_status', 'item_name', 'category_id', 'type_id', 'customer_name', 'view_level', 'from_date', 'to_date',], 'safe'],
            [['net_value', 'amount', 'deposit_amount'], 'number'],
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
        $query = BookingItem::find();

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
            'booking_item.item_id' => $this->item_id,
            'booking_item.booking_id' => $this->booking_id,
            'booking_item.item_no' => $this->item_no,
            'booking_item.product_id' => $this->product_id,
            'booking_item.net_value' => $this->net_value,
            'booking_item.item_type' => $this->item_type,
            'booking_item.item_category' => $this->item_category,
            'booking_item.amount' => $this->amount,
            'booking_item.discount' => $this->discount,
            'booking_item.deposit_amount' => $this->deposit_amount,
            'booking_item.deposite_charge_status' => $this->deposite_charge_status,
            'booking_item.pickup_date' => $this->pickup_date,
            'booking_item.picked_date' => $this->picked_date,
            'booking_item.return_date' => $this->return_date,
            'booking_item.returned_date' => $this->returned_date,
            'booking_item.payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'booking_item.description', $this->description])
            ->andFilterWhere(['like', 'booking_item.image_name', $this->image_name])
            ->andFilterWhere(['like', 'booking_item.item_status', $this->item_status])
            ->andFilterWhere(['like', 'booking_item.note', $this->note])
            ->andFilterWhere(['like', 'booking_item.deposite_status', $this->deposite_status]);

        return $dataProvider;
    }

    public function searchItem($params)
    {
        $query = ItemMaster::find()->select(['item_master.id as item_id', "sum(booking_item.`earning_amount`) as earning_amount", "sum(booking_item.`amount`) as amount", 'sum(case when `booking_item`.`item_status` = "Booked" OR `booking_item`.`item_status` = "Picked" OR `booking_item`.`item_status` = "Returned"  then 1 else 0 end) as rented_time', 'item_master.name as item_name', 'category_master.name as cat_name', 'type_master.name as type_name', 'item_master.item_code']);
        $query->leftJoin('booking_item', 'item_master.id = booking_item.product_id');
        //$query->leftJoin('booking_header', 'booking_item.booking_id = booking_item.booking_id');
        $query->leftJoin('type_master', 'type_master.id = item_master.type_id');
        $query->leftJoin('category_master', 'category_master.id = item_master.category_id');
        //$query->andWhere([ 'booking_item.item_status' => 'Returned']);
        $query->groupBy(['item_master.id']);
        $query->orderBy(['rented_time' => SORT_DESC]);
        //$date=date('m-Y');
        // add conditions that should always apply here
        // print_r($params);die;

        $this->load($params);
//print_r($this->item_name);die;
        if ($this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // grid filtering conditions
            $query->andFilterWhere([
                'booking_item.item_id' => $this->item_id,
                'booking_item.booking_id' => $this->booking_id,
                'booking_item.item_no' => $this->item_no,
                'booking_item.product_id' => $this->product_id,
                'booking_item.net_value' => $this->net_value,
                'booking_item.item_type' => $this->item_type,
                'booking_item.item_category' => $this->item_category,
                'booking_item.amount' => $this->amount,
                'booking_item.discount' => $this->discount,
                'booking_item.deposit_amount' => $this->deposit_amount,
                'booking_item.deposite_charge_status' => $this->deposite_charge_status,
                'booking_item.pickup_date' => $this->pickup_date,
                'booking_item.picked_date' => $this->picked_date,
                'booking_item.return_date' => $this->return_date,
                'booking_item.returned_date' => $this->returned_date,
                'booking_item.payment_status' => $this->payment_status,
                'item_master.category_id' => $this->category_id,
                'item_master.type_id' => $this->type_id,
            ]);

            $query->andFilterWhere(['like', 'booking_item.description', $this->description])
                ->andFilterWhere(['like', 'booking_item.image_name', $this->image_name])
                ->andFilterWhere(['like', 'booking_item.item_status', $this->item_status])
                ->andFilterWhere(['like', 'booking_item.note', $this->note])
                ->andFilterWhere(['like', 'customer_master.name', $this->customer_name])
                ->andFilterWhere(['like', 'item_master.name', $this->item_name])
                ->andFilterWhere(['like', 'booking_item.deposite_status', $this->deposite_status]);
            if ($this->from_date != '' && $this->to_date != '') {

                $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
                $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
                $booking_header = BookingHeader::find()->select('booking_id')->andWhere(['<=', 'booking_header.pickup_date', $date_format_to])->andWhere(['>=', 'booking_header.pickup_date', $date_format_from]);
                $query->andWhere(['OR',['booking_item.booking_id'=>$booking_header],['booking_item.booking_id'=>null]]);
                //$query->andWhere();
            }


        }
        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $query->createCommand()->queryAll(),
            'sort' => false,
        ]);


        /*$query->andWhere(['booking_header.order_status'=>array('Open','Closed','Cancelled')])->andWhere('DATE_FORMAT(booking_header.pickup_date, "%m-%Y") = "'. $this->date.'"');*/

        return $dataProvider;
    }

    public function searchItemCategory($params)
    {
        $query = ItemMaster::find()->select(['item_master.id as item_id', "sum(booking_item.`earning_amount`) as earning_amount", "sum(booking_item.`amount`) as amount", 'sum(case when `booking_item`.`item_status` = "Booked" OR `booking_item`.`item_status` = "Picked" OR `booking_item`.`item_status` = "Returned"  then 1 else 0 end) as rented_time', 'SUM(CASE WHEN `booking_item`.`item_status` = "Booked" OR `booking_item`.`item_status` = "Picked" OR `booking_item`.`item_status` = "Returned" OR `booking_item`.`item_status` = "Cancelled" OR  `booking_item`.`item_status` = "Deleted" THEN 0 ELSE 1 END) AS `unrented_items`', 'item_master.name as item_name', 'category_master.name as cat_name', 'type_master.name as type_name', 'count(DISTINCT `item_master`.`id`) as nos_item']);
        $query->leftJoin('booking_item', 'item_master.id = booking_item.product_id');
        $query->leftJoin('type_master', 'type_master.id = item_master.type_id');
        $query->leftJoin('category_master', 'category_master.id = item_master.category_id');
        //$query->andWhere([ 'booking_item.item_status' => 'Returned']);
        $query->groupBy(['item_master.category_id']);
        $query->orderBy(['rented_time' => SORT_DESC]);
        //$date=date('m-Y');
        // add conditions that should always apply here
        //print_r($params);die;

        $this->load($params);
        //print_r($this->item_name);die;
        if ($this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // grid filtering conditions
            $query->andFilterWhere([
                'booking_item.item_id' => $this->item_id,
                'booking_item.booking_id' => $this->booking_id,
                'booking_item.item_no' => $this->item_no,
                'booking_item.product_id' => $this->product_id,
                'booking_item.net_value' => $this->net_value,
                'booking_item.item_type' => $this->item_type,
                'booking_item.item_category' => $this->item_category,
                'booking_item.amount' => $this->amount,
                'booking_item.discount' => $this->discount,
                'booking_item.deposit_amount' => $this->deposit_amount,
                'booking_item.deposite_charge_status' => $this->deposite_charge_status,
                'booking_item.pickup_date' => $this->pickup_date,
                'booking_item.picked_date' => $this->picked_date,
                'booking_item.return_date' => $this->return_date,
                'booking_item.returned_date' => $this->returned_date,
                'booking_item.payment_status' => $this->payment_status,
                'item_master.category_id' => $this->category_id,
                'item_master.type_id' => $this->type_id,
            ]);

            $query->andFilterWhere(['like', 'booking_item.description', $this->description])
                ->andFilterWhere(['like', 'booking_item.image_name', $this->image_name])
                ->andFilterWhere(['like', 'booking_item.item_status', $this->item_status])
                ->andFilterWhere(['like', 'booking_item.note', $this->note])
                ->andFilterWhere(['like', 'customer_master.name', $this->customer_name])
                ->andFilterWhere(['like', 'item_master.name', $this->item_name])
                ->andFilterWhere(['like', 'booking_item.deposite_status', $this->deposite_status]);

        }
        if ($this->from_date != '' && $this->to_date != '') {

                $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
                $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
                $booking_header = BookingHeader::find()->select('booking_id')->andWhere(['<=', 'booking_header.pickup_date', $date_format_to])->andWhere(['>=', 'booking_header.pickup_date', $date_format_from]);
                $query->andWhere(['OR',['booking_item.booking_id'=>$booking_header],['booking_item.booking_id'=>null]]);
                //$query->andWhere();
            }
        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $query->createCommand()->queryAll(),
            'sort' => false,
        ]);


        /*$query->andWhere(['booking_header.order_status'=>array('Open','Closed','Cancelled')])->andWhere('DATE_FORMAT(booking_header.pickup_date, "%m-%Y") = "'. $this->date.'"');*/

        return $dataProvider;
    }

    public function searchItemType($params)
    {
        $query = ItemMaster::find()->select(["sum(booking_item.`earning_amount`) as earning_amount", "sum(booking_item.`amount`) as amount", 'sum(case when `booking_item`.`item_status` = "Booked" OR `booking_item`.`item_status` = "Picked" OR `booking_item`.`item_status` = "Returned"  then 1 else 0 end) as rented_time', 'SUM(CASE WHEN `booking_item`.`item_status` = "Booked" OR `booking_item`.`item_status` = "Picked" OR `booking_item`.`item_status` = "Returned" OR `booking_item`.`item_status` = "Cancelled" OR  `booking_item`.`item_status` = "Deleted" THEN 0 ELSE 1 END) AS `unrented_items`', 'item_master.name as item_name', 'category_master.name as cat_name', 'type_master.name as type_name', 'count(DISTINCT `item_master`.`id`) as nos_item']);
        $query->leftJoin('booking_item', 'item_master.id = booking_item.product_id');
        $query->leftJoin('type_master', 'type_master.id = item_master.type_id');
        $query->leftJoin('category_master', 'category_master.id = item_master.category_id');
        //$query->andWhere([ 'booking_item.item_status' => 'Returned']);
        $query->groupBy(['item_master.type_id']);
        $query->orderBy(['rented_time' => SORT_DESC]);
        //$date=date('m-Y');
        // add conditions that should always apply here
        //print_r($params);die;

        $this->load($params);
//print_r($this->item_name);die;
        if ($this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // grid filtering conditions
            $query->andFilterWhere([
                'booking_item.item_id' => $this->item_id,
                'booking_item.booking_id' => $this->booking_id,
                'booking_item.item_no' => $this->item_no,
                'booking_item.product_id' => $this->product_id,
                'booking_item.net_value' => $this->net_value,
                'booking_item.item_type' => $this->item_type,
                'booking_item.item_category' => $this->item_category,
                'booking_item.amount' => $this->amount,
                'booking_item.discount' => $this->discount,
                'booking_item.deposit_amount' => $this->deposit_amount,
                'booking_item.deposite_charge_status' => $this->deposite_charge_status,
                'booking_item.pickup_date' => $this->pickup_date,
                'booking_item.picked_date' => $this->picked_date,
                'booking_item.return_date' => $this->return_date,
                'booking_item.returned_date' => $this->returned_date,
                'booking_item.payment_status' => $this->payment_status,
                'item_master.category_id' => $this->category_id,
                'item_master.type_id' => $this->type_id,
            ]);

            $query->andFilterWhere(['like', 'booking_item.description', $this->description])
                ->andFilterWhere(['like', 'booking_item.image_name', $this->image_name])
                ->andFilterWhere(['like', 'booking_item.item_status', $this->item_status])
                ->andFilterWhere(['like', 'booking_item.note', $this->note])
                ->andFilterWhere(['like', 'customer_master.name', $this->customer_name])
                ->andFilterWhere(['like', 'item_master.name', $this->item_name])
                ->andFilterWhere(['like', 'booking_item.deposite_status', $this->deposite_status]);

        }
        if ($this->from_date != '' && $this->to_date != '') {

                $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
                $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
                $booking_header = BookingHeader::find()->select('booking_id')->andWhere(['<=', 'booking_header.pickup_date', $date_format_to])->andWhere(['>=', 'booking_header.pickup_date', $date_format_from]);
                $query->andWhere(['OR',['booking_item.booking_id'=>$booking_header],['booking_item.booking_id'=>null]]);
                //$query->andWhere();
            }
        $dataProvider = new ArrayDataProvider([
            'pagination' => false,
            'allModels' => $query->createCommand()->queryAll(),
            'sort' => false,
        ]);


        /*$query->andWhere(['booking_header.order_status'=>array('Open','Closed','Cancelled')])->andWhere('DATE_FORMAT(booking_header.pickup_date, "%m-%Y") = "'. $this->date.'"');*/

        return $dataProvider;
    }
}
