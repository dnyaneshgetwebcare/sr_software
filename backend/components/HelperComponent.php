<?php

namespace backend\components;

use backend\models\BookingItem;
use DateTime;
use yii\base\Component;
use yii\db\Expression;

class HelperComponent extends Component
{
  public function checkBooking($product_id, $pickup_date, $return_date, $booking_id = null)
  {
    $where_booking = ($booking_id == null) ? 1 : ['!=', 'booking_id', $booking_id];
    $booking_items = BookingItem::find()->select(['item_id', 'booking_id', 'product_id', 'item_no', 'pickup_date', 'return_date'])->where(['product_id' => $product_id])->andWhere("`pickup_date` <= '$return_date' and `return_date` >= '$pickup_date'")->andWhere(['item_status' => ['Booked', 'Picked']])->andWhere($where_booking)->orderBy(['pickup_date' => SORT_ASC])->asArray()->all();
    //
    $flag = 0;
    $message = "";
    // print_r($booking_items);die;
    $multi_items = [];
    $warning_items = [];
    if ($booking_items != null || sizeOf($booking_items)) {
      $flag = 1;
      $message = "Booking for Items exist. Booking Dates: ";
      //print_r($booking_items);
      foreach ($booking_items as $booking_item) {
        if (is_array($product_id)) {
          $multi_items[$booking_item['product_id']][] = $this->dateFormat($booking_item['pickup_date'], 'd-m-Y') . " -> " . $this->dateFormat($booking_item['return_date'], 'd-m-Y');
        } else {
          $message .= " [" . $this->dateFormat($booking_item['pickup_date'], 'd-m-Y') . " -> " . $this->dateFormat($booking_item['return_date'], 'd-m-Y') . "] ";
        }
      }
    }
    if (is_array($product_id)) {
      $pickup_date_temp = new DateTime($pickup_date);
      $pickup_date_temp->modify('-1 day');
      $fromdate = $pickup_date_temp->format('Y-m-d');
      $return_date_temp = new DateTime($return_date);
      $return_date_temp->modify('+1 day');
      $todate = $return_date_temp->format('Y-m-d');
      $booking_itm = BookingItem::find()->leftJoin('item_master', 'booking_item.product_id = item_master.id')->where
      (['>', 'dry_cleaning_treshold', 0])->andWhere(['product_id' => $product_id])->andWhere(['or', ["between", 'return_date', new Expression('DATE_SUB("'
        . $pickup_date . '", INTERVAL item_master.`dry_cleaning_treshold` DAY)'), $fromdate], ["between", 'pickup_date', $todate, new Expression('DATE_ADD("' . $return_date . '", INTERVAL item_master.`dry_cleaning_treshold` DAY)')]])->orderBy(['pickup_date' => SORT_ASC])
        ->asArray
        ()->all();
      foreach ($booking_itm as $book_item) {
        if (!isset($multi_items[$book_item['product_id']])) {
          $warning_items[$book_item['product_id']][] = $this->dateFormat($book_item['pickup_date'], 'd-m-Y') . " -> " . $this->dateFormat($book_item['return_date'], 'd-m-Y');
        }

      }

    }
    //return array('status'=>$flag,'errors'=>array($message));


    return array('flag' => $flag, 'errors' => array($message), 'multi_items' => $multi_items, 'warning' => $warning_items);
  }

  public function dateFormat($request_date, $req_format = null)
  {
    $req_format = ($req_format == null) ? 'Y-m-d' : $req_format;
    return ($request_date != '') ? date($req_format, strtotime($request_date)) : '';
  }

  public function getImageurl($images)
  {
    if ($images != '') {
      return \Yii::$app->request->BaseUrl . '/uploads/' . $images;
    } else {
      return \Yii::$app->request->BaseUrl . '/img/no-image.jpg';
    }
  }
}