<?php

namespace backend\controllers;

use backend\models\BookingHeader;
use backend\models\BookingItem;
use backend\models\CustomerMaster;

use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class PackingController extends \yii\web\Controller
{
  public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                  [
                        'actions' => ['index','customer-search','booking-search','get-packing-item'],
                        'allow' => true,
                        'roles' => ['manage_packing'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
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
    if(Yii::$app->request->isAjax) {
       Yii::$app->response->format = Response::FORMAT_JSON;
      $_selected_items = isset($_POST['selected_item']) ? $_POST['selected_item'] :null;
      if ($_selected_items == null) {
        return array("error" => "Please select items for packing", 'flag' => false);
      }
      $_selected_boooking_ids_all = isset($_POST['selected_header']) ? $_POST['selected_header'] : array();
      foreach ($_selected_boooking_ids_all as $_selected_boooking_id_header) {
        BookingItem::updateAll(['packing_status' => 'Packed'], ['booking_id' => $_selected_boooking_id_header]);
        unset($_selected_items[$_selected_boooking_id_header]);
      }
      foreach ($_selected_items as $selected_booking_id => $selected_item) {

        BookingItem::updateAll(['packing_status' => 'Packed'], ['booking_id' => $selected_booking_id, 'item_no' => $selected_item]);
      }
       return array('flag' => true);
    }
    $booking_ids = isset($_POST['booking_id_filter'])?$_POST['booking_id_filter'] : '';
    $customer_ids = isset($_POST['customer_filter'])?$_POST['customer_filter'] : '';
    $post_pickup_date = isset($_POST['filter_pickup_date'])?$_POST['filter_pickup_date'] : '';
    $pickup_date = Yii::$app->helpercomponent->dateFormat($post_pickup_date);

    //if($booking_ids != null || $customer_ids!= null || $pickup_date!= null){
      $booking_details = BookingItem::find()->select(['booking_header.booking_id', 'booking_header.pickup_date', 'booking_header.remark', 'customer_master.name as customer_name', 'item_master.name as description', 'booking_item.item_no', 'note', 'images'])->leftJoin('booking_header', 'booking_header.booking_id= booking_item.booking_id')->leftJoin('customer_master', 'customer_master.id = booking_header.customer_id')->where(['booking_item.item_status'=>'Booked', 'booking_header.order_status' => 'Open', 'booking_item.packing_status'=> 'Unpacked'])->leftJoin('item_master','item_master.id = booking_item.product_id')->andFilterWhere(['booking_header.booking_id' => $booking_ids, 'customer_id'=> $customer_ids, 'booking_header.pickup_date' => $pickup_date ])->createCommand()->queryAll();
        return $this->render('packing_items',['booking_details'=> $booking_details, 'booking_ids'=>$booking_ids, 'customer_ids'=>$customer_ids,'post_pickup_date' => $post_pickup_date]);
   // }


}

}
