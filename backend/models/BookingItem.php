<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_item".
 *
 * @property int $item_id
 * @property int $booking_id
 * @property int $item_no
 * @property int $product_id
 * @property string $image_name
 * @property string $amount
 * @property string $deposit_amount
 * @property int $deposite_charge_status
 * @property string $pickup_date
 * @property string $picked_date
 * @property string $return_date
 * @property string $returned_date
 * @property string $item_status
 * @property string $note
 * @property string $discount
 * @property string $deposite_status
 * @property int $payment_status
 *
 * @property BookingHeader $booking
 * @property ItemMaster $item
 */
class BookingItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $sr_no;
    public static function tableName()
    {
        return 'booking_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[  'product_id', 'amount', 'deposit_amount'], 'required'],
            [['booking_id', 'item_no', 'product_id', 'deposite_charge_status', 'payment_status'], 'integer'],
            [['amount', 'deposit_amount'], 'number'],
            [['pickup_date', 'picked_date', 'return_date', 'returned_date','description','net_value','discount', 'item_no','item_status', 'deposite_status','item_id','item_type','item_category','extra_per','earning_amount'], 'safe'],
            [['item_status', 'note', 'deposite_status'], 'string'],
            [['image_name'], 'string', 'max' => 50],
          /*  [['booking_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookingHeader::className(), 'targetAttribute' => ['booking_id' => 'booking_id']],*/
           /* [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemMaster::className(), 'targetAttribute' => ['item_id' => 'id']],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'booking_id' => 'Booking ID','description' => 'Description',
            'item_no' => 'Item No',
            'product_id' => 'Item',
            'net_value' => 'Net Value',
            'item_type' => 'Item Type',
            'item_category' => 'Item Catergory',
            'image_name' => 'Image Name',
            'amount' => 'Amount',
            'deposit_amount' => 'Deposit Amount',
            'deposite_charge_status' => 'Deposite Charge Status',
            'pickup_date' => 'Pickup Date',
            'picked_date' => 'Picked Date',
            'return_date' => 'Return Date',
            'returned_date' => 'Returned Date',
            'item_status' => 'Item Status',
            'note' => 'Note',
            'extra_per' => 'Extra',
            'discount'=>'Discount',
            'deposite_status' => 'Deposite Status',
            'payment_status' => 'Payment Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(BookingHeader::className(), ['booking_id' => 'booking_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(ItemMaster::className(), ['id' => 'product_id']);
    }
    public function getType()
    {
        return $this->hasOne(TypeMaster::className(), ['id' => 'item_type']);
    }
     public function getCategory()
    {
        return $this->hasOne(TypeMaster::className(), ['id' => 'item_category']);
    }
    public function getCategoryMaster()
    {
        return $this->hasOne(CategoryMaster::className(), ['id' => 'item_category']);
    }
        public static function getTotal($provider, $columnName)
{
    $total = 0;
    foreach ($provider as $item) {
      $total += $item[$columnName];
  }
  return number_format($total);  
}
}
