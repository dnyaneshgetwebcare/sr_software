<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PaymentMaster;
use yii\data\ArrayDataProvider;

/**
 * PaymentMasterSearch represents the model behind the search form of `backend\models\PaymentMaster`.
 */
class PaymentMasterSearch extends PaymentMaster
{
  /**
   * {@inheritdoc}
   */
  public $customer_name, $month_year_filter, $from_date, $to_date, $search_cust, $view_level, $search_mode;

  public function rules()
  {
    return [
      [['payment_id', 'amount', 'booking_id'], 'integer'],
      [['date', 'type', 'mode_of_payment', 'received_by', 'received_during', 'dom', 'sendto', 'customer_name', 'month_year_filter', 'from_date', 'to_date', 'search_cust', 'view_level', 'search_mode'], 'safe'],
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
//ALTER TABLE `booking_header` ADD `skip` INT(1) NOT NULL DEFAULT '0' AFTER `updated_time`;
  public function searchReport($params)
  {
    # code...

    $query = BookingHeader::find()->select(['payment_master.date', 'booking_header.booking_id', 'customer_master.name as customer_name', 'payment_master.type', 'payment_master.mode_of_payment', 'payment_master.received_by', 'payment_master.sendto', 'payment_master.received_during', 'payment_master.amount', 'booking_header.pickup_date', 'booking_header.return_date', 'booking_header.booking_date', 'booking_header.rent_amount', 'booking_header.discount', 'booking_header.extra_amount', 'booking_header.issues_penalty', 'booking_header.deposite_amount', 'booking_header.return_amount', 'booking_header.cancellation_charges', 'booking_header.order_status', 'booking_header.other_charges'])->leftJoin('payment_master', 'booking_header.booking_id = payment_master.booking_id')->leftJoin('customer_master', 'booking_header.customer_id=customer_master.id');

    // add conditions that should always apply here

    /* $dataProvider = new ArrayDataProvider([
         'query' => $query,
     ]);*/

    $this->load($params);

    /*  if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }*/
    //print_r($this);
    if ($this->from_date != '' && $this->to_date != '') {
      $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
      $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
      $query->andWhere(['>=', 'booking_header.pickup_date', $date_format_from]);
      $query->andWhere(['<=', 'booking_header.pickup_date', $date_format_to]);
    }
    $date_format = ($this->date != '') ? date('Y-m-d', strtotime($this->date)) : '';
    // grid filtering conditions
    $query->andFilterWhere([
      'payment_id' => $this->payment_id,
      'date' => $date_format,
      'dom' => $this->dom,
      'amount' => $this->amount,
      // 'booking_id' => $this->booking_id,
    ]);
    if ($this->month_year_filter != '' && $this->date == '') {
      $query->andWhere('DATE_FORMAT(date, "%m-%Y") = "' . $this->month_year_filter . '"');
    }
    $query->andWhere(['skip' => 0]);
    $query->andFilterWhere(['type' => $this->type])
      ->andFilterWhere(['mode_of_payment' => $this->mode_of_payment])
      ->andFilterWhere(['like', 'received_by', $this->received_by])
      ->andFilterWhere(['like', 'received_during', $this->received_during])
      ->andFilterWhere(['customer_master.name' => $this->customer_name])
      ->andFilterWhere(['like', 'sendto', $this->sendto]);
//echo $query->createCommand()->getRawSql();die;
    $query->orderBy(['pickup_date' => SORT_ASC, 'booking_id' => SORT_ASC, 'date' => SORT_ASC]);
    $dataProvider = new ArrayDataProvider([
      //'pagination' => ['pageSize' => $this->PAGE_SIZE],
      'pagination' => false,
      'allModels' => $query->createCommand()->queryAll(),
      'sort' => false,
    ]);
    return $dataProvider;

  }

  public function searchOverview($params)
  {
    # code...
    // $payment_master = PaymentMaster::find()->select(["type","sum( CASE WHEN (`mode_of_payment` = 'Cash' AND (`type` <> 'Return-Payment' AND `type` <>  'Return-Deposit')) THEN `amount` ELSE 0 END) AS cash_amount_reci","sum( CASE WHEN (`mode_of_payment` = 'Cash' AND (`type` = 'Return-Payment' || `type` =  'Return-Deposit')) THEN `amount` ELSE 0 END) AS cash_amount_return","sum(CASE WHEN ((`mode_of_payment` = 'Google Pay' OR `mode_of_payment` = 'Phone Pe' OR `mode_of_payment` = 'Bank Transfer' OR `mode_of_payment` = 'Paytm') AND (`type` <> 'Return-Payment' AND `type` <>  'Return-Deposit')) THEN `amount`   ELSE 0 END) AS online_amount_recived", "sum(CASE WHEN ((`mode_of_payment` = 'Google Pay' OR `mode_of_payment` = 'Phone Pe' OR `mode_of_payment` = 'Bank Transfer' OR `mode_of_payment` = 'Paytm') AND (`type`= 'Return-Payment' || `type` =  'Return-Deposit')) THEN `amount`   ELSE 0 END ) AS online_amount_return"]);

    $payment_master = "(SELECT  SUM(CASE WHEN(`mode_of_payment` = 'Cash' AND(`type` <> 'Return-Payment' AND `type` <> 'Return-Deposit')) THEN `amount` ELSE 0 END) AS cash_amount_reci, SUM(CASE WHEN(`mode_of_payment` = 'Cash' AND( `type` = 'Return-Payment' || `type` = 'Return-Deposit' )) THEN `amount` ELSE 0 END ) AS cash_amount_return, SUM(CASE WHEN( ( `mode_of_payment` = 'Google Pay' OR `mode_of_payment` = 'Phone Pe' OR `mode_of_payment` = 'Bank Transfer' OR `mode_of_payment` = 'Paytm' ) AND(`type` <> 'Return-Payment' AND `type` <> 'Return-Deposit' )) THEN `amount` ELSE 0 END ) AS online_amount_recived, SUM(CASE WHEN( (`mode_of_payment` = 'Google Pay' OR `mode_of_payment` = 'Phone Pe' OR `mode_of_payment` = 'Bank Transfer' OR `mode_of_payment` = 'Paytm' ) AND(`type` = 'Return-Payment' || `type` = 'Return-Deposit' ) ) THEN `amount` ELSE 0 END ) AS online_amount_return, `booking_id` FROM `payment_master`GROUP BY booking_id)";
    $query = BookingHeader::find()->select(['booking_header.booking_id', 'customer_master.name as customer_name', 'payment_summary.cash_amount_reci', 'payment_summary.cash_amount_return', 'payment_summary.online_amount_recived', 'payment_summary.online_amount_return', 'booking_header.pickup_date', 'booking_header.return_date', 'booking_header.booking_date', 'booking_header.rent_amount', 'booking_header.discount', 'booking_header.extra_amount', 'booking_header.issues_penalty', 'booking_header.deposite_amount', 'booking_header.return_amount', 'booking_header.cancellation_charges', 'booking_header.order_status', 'booking_header.other_charges'])->leftJoin($payment_master . " as payment_summary", 'booking_header.booking_id = payment_summary.booking_id')->leftJoin('customer_master', 'booking_header.customer_id=customer_master.id');

    // add conditions that should always apply here

    /* $dataProvider = new ArrayDataProvider([
         'query' => $query,
     ]);*/

    $this->load($params);

    /*  if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }*/
    //print_r($this);
    if ($this->from_date != '' && $this->to_date != '') {
      $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
      $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
      $query->andWhere(['>=', 'booking_header.pickup_date', $date_format_from]);
      $query->andWhere(['<=', 'booking_header.pickup_date', $date_format_to]);
    }
    $date_format = ($this->date != '') ? date('Y-m-d', strtotime($this->date)) : '';
    // grid filtering conditions
    $query->andFilterWhere([
      'payment_id' => $this->payment_id,
      'date' => $date_format,
      'dom' => $this->dom,
      'amount' => $this->amount,
      // 'booking_id' => $this->booking_id,
    ]);
    if ($this->month_year_filter != '' && $this->date == '') {
      $query->andWhere('DATE_FORMAT(date, "%m-%Y") = "' . $this->month_year_filter . '"');
    }
    $query->andFilterWhere(['type' => $this->type])
      ->andFilterWhere(['mode_of_payment' => $this->mode_of_payment])
      ->andFilterWhere(['like', 'received_by', $this->received_by])
      ->andFilterWhere(['like', 'received_during', $this->received_during])
      ->andFilterWhere(['customer_master.name' => $this->customer_name])
      ->andFilterWhere(['like', 'sendto', $this->sendto]);
//echo $query->createCommand()->getRawSql();die;
    $query->orderBy(['pickup_date' => SORT_ASC, 'booking_id' => SORT_ASC]);
    $dataProvider = new ArrayDataProvider([
      //'pagination' => ['pageSize' => $this->PAGE_SIZE],
      'pagination' => false,
      'allModels' => $query->createCommand()->queryAll(),
      'sort' => false,
    ]);
    return $dataProvider;

  }

  public function searchSummary($params)
  {
    # code...

    /*$query = PaymentMaster::find()->select(['payment_master.date','booking_header.booking_id','customer_master.name as customer_name','payment_master.type','payment_master.mode_of_payment','payment_master.received_by','payment_master.sendto','payment_master.received_during','payment_master.amount','booking_header.pickup_date','booking_header.return_date','booking_header.booking_date','booking_header.rent_amount','booking_header.deposite_amount','booking_header.return_amount','booking_header.cancellation_charges','booking_header.other_charges'])->leftJoin('booking_header','payment_master.booking_id = booking_header.booking_id')->leftJoin('customer_master','booking_header.customer_id=customer_master.id');*/
    $query = PaymentMaster::find()->select(['payment_master.date', 'sum(case when (`mode_of_payment` = "Cash" and (`type` = "Advance" or `type` = "Per-payment" or `type` = "Deposit" or `type` = "Final-Payment" or `type` = "Cancel-Charge")) then amount else 0 end) as cash_rec', 'sum(case when (`mode_of_payment` = "Cash" and (`type` = "Return-Deposit" or `type` = "Return-Payment")) then amount else 0 end) as cash_return', 'sum(case when ((`mode_of_payment` != "Cash" and `mode_of_payment` != "Deposit" AND `mode_of_payment` != "Credit" AND `mode_of_payment` != "Carry_Frwd")  and (`type` = "Advance" or `type` = "Per-payment" or `type` = "Deposit" or `type` = "Final-Payment" or `type` = "Cancel-Charge")) then amount else 0 end) as online_rec',
      'sum(case when ((`mode_of_payment` != "Cash" and `mode_of_payment` != "Deposit" AND `mode_of_payment` != "Credit" AND `mode_of_payment` != "Carry_Frwd")  and (`type` = "Advance" or `type` = "Per-payment" or `type` = "Deposit" or `type` = "Final-Payment" or `type` = "Cancel-Charge")) and (sendto = "Company") then amount else 0 end) as online_rec_comp',
      'sum(case when ((`mode_of_payment` != "Cash" and `mode_of_payment` != "Deposit" AND `mode_of_payment` != "Credit" AND `mode_of_payment` != "Carry_Frwd")  and (`type` = "Advance" or `type` = "Per-payment" or `type` = "Deposit" or `type` = "Final-Payment" or `type` = "Cancel-Charge")) and (sendto != "Company") then amount else 0 end) as online_rec_other',
      'sum(case when ((`mode_of_payment` != "Cash" and `mode_of_payment` != "Deposit" AND `mode_of_payment` != "Credit" AND `mode_of_payment` != "Carry_Frwd") and (`type` = "Return-Deposit" or `type` = "Return-Payment")) then amount else 0 end) as online_return', 'sum(case when ((`mode_of_payment` = "Deposit")) then amount else 0 end) as charge_on'])->groupBy(['payment_master.date']);

    // add conditions that should always apply here

    /* $dataProvider = new ArrayDataProvider([
         'query' => $query,
     ]);*/

    $this->load($params);

    /*  if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }*/
    //print_r($this);
    if ($this->from_date != '' && $this->to_date != '') {
      $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
      $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
      $query->andWhere(['>=', 'date', $date_format_from]);
      $query->andWhere(['<=', 'date', $date_format_to]);
    }
    $date_format = ($this->date != '') ? date('Y-m-d', strtotime($this->date)) : '';
    // grid filtering conditions
    $query->andFilterWhere([
      'payment_id' => $this->payment_id,
      'date' => $date_format,
      'dom' => $this->dom,
      'amount' => $this->amount,
      // 'booking_id' => $this->booking_id,
    ]);
    if ($this->month_year_filter != '' && $this->date == '') {
      $query->andWhere('DATE_FORMAT(date, "%m-%Y") = "' . $this->month_year_filter . '"');
    }
    $query->andFilterWhere(['type' => $this->type])
      ->andFilterWhere(['mode_of_payment' => $this->mode_of_payment])
      ->andFilterWhere(['like', 'received_by', $this->received_by])
      ->andFilterWhere(['like', 'received_during', $this->received_during])
      // ->andFilterWhere(['customer_master.name'=> $this->customer_name])
      ->andFilterWhere(['like', 'sendto', $this->sendto]);
//echo $query->createCommand()->getRawSql();die;
    $query->orderBy(['date' => SORT_ASC]);
    $dataProvider = new ArrayDataProvider([
      //'pagination' => ['pageSize' => $this->PAGE_SIZE],
      'pagination' => false,
      'allModels' => $query->createCommand()->queryAll(),
      'sort' => false,
    ]);
    return $dataProvider;

  }

  public function search($params)
  {
    $query = PaymentMaster::find()->joinWith(['booking.customer']);

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    /*  if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }*/
    $date_format = ($this->date != '') ? date('Y-m-d', strtotime($this->date)) : '';
    // grid filtering conditions
    if ($this->from_date != '' && $this->to_date != '') {
      $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
      $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
      $query->andWhere(['>=', 'date', $date_format_from]);
      $query->andWhere(['<=', 'date', $date_format_to]);
    }
    $query->andFilterWhere([
      'payment_id' => $this->payment_id,
      'date' => $date_format,
      'dom' => $this->dom,
      'amount' => $this->amount,
      // 'booking_id' => $this->booking_id,
    ]);
    if ($this->month_year_filter != '' && $this->date == '' && $this->from_date == '' && $this->to_date == '') {
      $query->andWhere('DATE_FORMAT(date, "%m-%Y") = "' . $this->month_year_filter . '"');
    }
    $query->andFilterWhere(['like', 'type', $this->type])
      ->andFilterWhere(['like', 'mode_of_payment', $this->mode_of_payment])
      ->andFilterWhere(['like', 'received_by', $this->received_by])
      ->andFilterWhere(['like', 'received_during', $this->received_during])
      ->andFilterWhere(['like', 'customer_master.name', $this->customer_name])
      ->andFilterWhere(['like', 'sendto', $this->sendto]);
//echo $query->createCommand()->getRawSql();die;
    return $dataProvider;
  }

  public function searchTransaction($params)
  {
    # code...

    /*$query = PaymentMaster::find()->select(['payment_master.date','booking_header.booking_id','customer_master.name as customer_name','payment_master.type','payment_master.mode_of_payment','payment_master.received_by','payment_master.sendto','payment_master.received_during','payment_master.amount','booking_header.pickup_date','booking_header.return_date','booking_header.booking_date','booking_header.rent_amount','booking_header.deposite_amount','booking_header.return_amount','booking_header.cancellation_charges','booking_header.other_charges'])->leftJoin('booking_header','payment_master.booking_id = booking_header.booking_id')->leftJoin('customer_master','booking_header.customer_id=customer_master.id');*/
    $query = PaymentMaster::find()->select(['payment_master.date', 'booking_header.booking_id', 'customer_master.name as customer_name', 'payment_master.type', 'payment_master.mode_of_payment', 'payment_master.received_by', 'payment_master.sendto', 'payment_master.received_during', 'payment_master.amount', 'booking_header.pickup_date', 'booking_header.return_date', 'booking_header.booking_date', 'booking_header.rent_amount', 'booking_header.discount', 'booking_header.extra_amount', 'booking_header.issues_penalty', 'booking_header.deposite_amount', 'booking_header.return_amount', 'booking_header.cancellation_charges', 'booking_header.order_status', 'booking_header.other_charges'])->leftJoin('booking_header', 'booking_header.booking_id = payment_master.booking_id')->leftJoin('customer_master', 'booking_header.customer_id=customer_master.id');

    // add conditions that should always apply here

    /* $dataProvider = new ArrayDataProvider([
         'query' => $query,
     ]);*/

    $this->load($params);

    /*  if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }*/
    //print_r($this);
    if ($this->from_date != '' && $this->to_date != '') {
      $date_format_from = ($this->from_date != '') ? date('Y-m-d', strtotime($this->from_date)) : '';
      $date_format_to = ($this->to_date != '') ? date('Y-m-d', strtotime($this->to_date)) : '';
      $query->andWhere(['>=', 'date', $date_format_from]);
      $query->andWhere(['<=', 'date', $date_format_to]);
    }
    $date_format = ($this->date != '') ? date('Y-m-d', strtotime($this->date)) : '';
    // grid filtering conditions
    $query->andFilterWhere([
      'payment_id' => $this->payment_id,
      'date' => $date_format,
      'dom' => $this->dom,
      'amount' => $this->amount,
      // 'booking_id' => $this->booking_id,
    ]);
    if ($this->month_year_filter != '' && $this->date == '') {
      $query->andWhere('DATE_FORMAT(date, "%m-%Y") = "' . $this->month_year_filter . '"');
    }
    $query->andFilterWhere(['type' => $this->type])
      ->andFilterWhere(['mode_of_payment' => $this->mode_of_payment])
      ->andFilterWhere(['like', 'received_by', $this->received_by])
      ->andFilterWhere(['like', 'received_during', $this->received_during])
      // ->andFilterWhere(['customer_master.name'=> $this->customer_name])
      ->andFilterWhere(['like', 'sendto', $this->sendto]);
//echo $query->createCommand()->getRawSql();die;
    $query->orderBy(['date' => SORT_ASC]);
    $dataProvider = new ArrayDataProvider([
      //'pagination' => ['pageSize' => $this->PAGE_SIZE],
      'pagination' => false,
      'allModels' => $query->createCommand()->queryAll(),
      'sort' => false,
    ]);
    return $dataProvider;

  }

  public function searchReconcileBankTransaction($params)
  {
    # code...
    $query = PaymentMaster::find()->select(['payment_master.payment_id', 'payment_master.date', 'booking_header.booking_id', 'customer_master.name as customer_name', 'payment_master.type', 'payment_master.mode_of_payment', 'payment_master.sendto', 'payment_master.amount', 'booking_header.pickup_date', 'booking_header.return_date', 'booking_header.booking_date', 'payment_master.remark'])->leftJoin('booking_header', 'booking_header.booking_id = payment_master.booking_id')->leftJoin('customer_master', 'booking_header.customer_id=customer_master.id');

    // Filter: payment mode NOT IN ('cash', 'deposit', 'Carry_Frwd')
    $query->andWhere(['NOT IN', 'payment_master.mode_of_payment', ['Cash', 'Deposit', 'Carry_Frwd']]);
    
    // Filter: type NOT IN ('Return-Deposit', 'Return-Payment')
    $query->andWhere(['NOT IN', 'payment_master.type', ['Return-Deposit', 'Return-Payment']]);

    $this->load($params);

    // Single date filtering
    $date_format = '';
    if ($this->date != '') {
      // Convert dd-mm-yyyy to Y-m-d format
      $date_parts = explode('-', $this->date);
      if (count($date_parts) == 3) {
        $date_format = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
      } else {
        $date_format = date('Y-m-d', strtotime($this->date));
      }
      $query->andWhere(['payment_master.date' => $date_format]);
    } else {
      // Default to today's date if no date is selected
      $date_format = date('Y-m-d');
      $query->andWhere(['payment_master.date' => $date_format]);
    }
    
    // grid filtering conditions
    $query->andFilterWhere([
      'payment_master.payment_id' => $this->payment_id,
      'payment_master.dom' => $this->dom,
      'payment_master.amount' => $this->amount,
    ]);
    
    $query->andFilterWhere(['like', 'payment_master.type', $this->type])
      ->andFilterWhere(['like', 'payment_master.mode_of_payment', $this->mode_of_payment])
      ->andFilterWhere(['like', 'customer_master.name', $this->customer_name])
      ->andFilterWhere(['like', 'payment_master.sendto', $this->sendto]);
    
    $query->orderBy(['payment_master.date' => SORT_DESC, 'payment_master.payment_id' => SORT_DESC]);
    
    $dataProvider = new ArrayDataProvider([
      'pagination' => false,
      'allModels' => $query->createCommand()->queryAll(),
      'sort' => false,
    ]);
    
    return $dataProvider;
  }
}
