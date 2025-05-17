<?php

namespace backend\controllers;

use backend\models\BookingHeader;
use backend\models\BookingItem;
use backend\models\CustomerMaster;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PackingController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $filter_date = isset($_POST['filter_date'])? $_POST['filter_date'] : '';
      //$filter_date = isset($_POST['filter_date'])? $_POST['filter_date'] : '';

      $customer_list = CustomerMaster::find()->limit(50)->all();
      $customer_list = ArrayHelper::map($customer_list, 'id','name');

        return $this->render('index',['filter_date'=> $filter_date,'customer_list' =>$customer_list ]);
    }

    public function actionCustomerSearch($q = null, $id = null) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('id, name AS text')
            ->from('customer_master')
            ->where(['like', 'name', $q])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
    }
    elseif ($id > 0) {
        $out['results'] = ['id' => $id, 'text' => CustomerMaster::find($id)->name];
    }
    return $out;
}
public function actionBookingSearch($q = null, $id = null) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('booking_id as id, booking_id AS text')
            ->from('booking_item')
            ->where(['like', 'booking_id', $q])
          ->andWhere(['item_status' => 'Booked'])->groupBy(['booking_id'])
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['results'] = array_values($data);
    }
    elseif ($id > 0) {
        $out['results'] = ['id' => $id, 'text' => BookingItem::find($id)->andWhere(['item_status' => 'Booked'])->groupBy(['booking_id'])->booking_id];
    }
    return $out;
}

  function actionGetPackingItem()
  {

    $booking_ids = isset($_POST['booking_id_filter'])?$_POST['booking_id_filter'] : null;
    $customer_ids = isset($_POST['customer_filter'])?$_POST['customer_filter'] : null;
    $pickup_date = isset($_POST['filter_pickup_date'])?Yii::$app->helpercomponent->dateFormat($_POST['filter_pickup_date']) : null;

    //if($booking_ids != null || $customer_ids!= null || $pickup_date!= null){
      $booking_details = BookingItem::find()->select(['booking_header.booking_id', 'booking_header.pickup_date', 'booking_header.remark', 'customer_master.name as customer_name', 'item_master.name as description', 'booking_item.item_no', 'note', 'images'])->leftJoin('booking_header', 'booking_header.booking_id= booking_item.booking_id')->leftJoin('customer_master', 'customer_master.id = booking_header.customer_id')->where(['booking_item.item_status'=>'Booked', 'booking_header.order_status' => 'Open'])->leftJoin('item_master','item_master.id = booking_item.product_id')->andFilterWhere(['booking_header.booking_id' => $booking_ids, 'customer_id'=> $customer_ids, 'booking_header.pickup_date' => $pickup_date ])->createCommand()->queryAll();
        return $this->render('packing_items',['booking_details'=> $booking_details]);
   // }


}

}
