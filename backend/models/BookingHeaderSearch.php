<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BookingHeader;

/**
 * BookingHeaderSearch represents the model behind the search form of `backend\models\BookingHeader`.
 */

class BookingHeaderSearch extends BookingHeader
{
    /**
     * {@inheritdoc}
     */
    public $customer_name,$month_year_filter,$item_category,$item_type;
    public function rules()
    {
        return [
            [['booking_id', 'deposite_applicable', 'payment_status', 'customer_id'], 'integer'],
            [['booking_date', 'pickup_date', 'picked_date', 'return_date', 'returned_date', 'deposite_status', 'order_status', 'status','customer_name','month_year_filter','item_category','item_type'], 'safe'],
            [['net_value', 'discount', 'deposite_amount'], 'number'],
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
     
          
    public function search_category($params)
    {
        $query = BookingHeader::find()->joinWith(['customer','bookingItems']);

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
$booking_date_format=( $this->booking_date!='')?date('Y-m-d',strtotime( $this->booking_date)):'';
$pickup_date_format=( $this->pickup_date!='')?date('Y-m-d',strtotime( $this->pickup_date)):'';
$return_date_format=( $this->return_date!='')?date('Y-m-d',strtotime( $this->return_date)):'';


        $query->andFilterWhere([
            'booking_header.booking_id' => $this->booking_id,
            'booking_header.booking_date' => $booking_date_format,
            'booking_header.pickup_date' => $pickup_date_format,
            'booking_header.picked_date' => $this->picked_date,
            'booking_header.return_date' => $return_date_format,
            'booking_header.returned_date' => $this->returned_date,
            'booking_item.item_category' => $this->item_category,
            'booking_item.item_type' => $this->item_type,
            'booking_header.net_value' => $this->net_value,
            'booking_header.discount' => $this->discount,
            'booking_header.order_status' => $this->order_status,
            'booking_header.deposite_applicable' => $this->deposite_applicable,
            'booking_header.deposite_amount' => $this->deposite_amount,
            'booking_header.payment_status' => $this->payment_status,
           // 'customer_id' => $this->customer_id,
        ]);
        if($this->month_year_filter!='' && $this->pickup_date==''){
          $query->andWhere('DATE_FORMAT(booking_header.pickup_date, "%m-%Y") = "'. $this->month_year_filter.'"');
        }

        $query->andFilterWhere(['like', 'booking_header.deposite_status', $this->deposite_status])
           // ->andFilterWhere(['like', 'order_status', $this->order_status])
            ->andFilterWhere(['like', 'booking_header.status', $this->status])
            ->andFilterWhere(['like', 'customer_master.name', $this->customer_name]);

        return $dataProvider;
    }
     
    public function search($params)
    {
        $query = BookingHeader::find()->joinWith(['customer']);

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
$booking_date_format=( $this->booking_date!='')?date('Y-m-d',strtotime( $this->booking_date)):'';
$pickup_date_format=( $this->pickup_date!='')?date('Y-m-d',strtotime( $this->pickup_date)):'';
$return_date_format=( $this->return_date!='')?date('Y-m-d',strtotime( $this->return_date)):'';


        $query->andFilterWhere([
            'booking_id' => $this->booking_id,
            'booking_date' => $booking_date_format,
            'pickup_date' => $pickup_date_format,
            'picked_date' => $this->picked_date,
            'return_date' => $return_date_format,
            'returned_date' => $this->returned_date,
            'net_value' => $this->net_value,
            'discount' => $this->discount,
            'order_status' => $this->order_status,
            'deposite_applicable' => $this->deposite_applicable,
            'deposite_amount' => $this->deposite_amount,
            'payment_status' => $this->payment_status,
           // 'customer_id' => $this->customer_id,
        ]);
        if($this->month_year_filter!='' && $this->pickup_date==''){
          $query->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "'. $this->month_year_filter.'"');
        }

        $query->andFilterWhere(['like', 'deposite_status', $this->deposite_status])
           // ->andFilterWhere(['like', 'order_status', $this->order_status])
            ->andFilterWhere(['like', 'booking_header.status', $this->status])
            ->andFilterWhere(['like', 'customer_master.name', $this->customer_name]);

        return $dataProvider;
    }
}
