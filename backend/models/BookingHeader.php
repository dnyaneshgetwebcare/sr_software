<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "booking_header".
 *
 * @property int $booking_id
 * @property string $booking_date
 * @property string $event_date
 * @property string $pickup_date
 * @property string $picked_date
 * @property string $return_date
 * @property string $returned_date
 * @property string $net_value
 * @property string $discount
 * @property int $deposite_applicable
 * @property string $deposite_amount
 * @property int $payment_status
 * @property int $customer_id
 * @property string $deposite_status
 * @property string $order_status
 * @property string $status
 *
 * @property CustomerMaster $customer
 * @property BookingItem[] $bookingItems
 */
class BookingHeader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
       public function behaviors()
  {
    return [
      ['class' => \yii\behaviors\TimestampBehavior::className(),
        'attributes' => [
          ActiveRecord::EVENT_AFTER_VALIDATE => ['updated_time'],
        ],
        // if you're using datetime instead of UNIX timestamp:
        'value' => new Expression('NOW()'),
      ]
    ];
  }
/* test co*/
    public static function tableName()
    {
        return 'booking_header';
    }
    public $diplay_amount,$picked_up,$cancel_flag,$pending_amount,$settl_booking_id,$open_balance, $updated_time_temp;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['booking_date', 'net_value', 'discount','paid_amount','refunded'], 'required'],
            [['pickup_date', 'return_date'], 'required','when' => function ($model) { 
              return $model->postpond == 0; 
          }, ],
            [['booking_date', 'event_date', 'pickup_date', 'picked_date', 'return_date', 'returned_date', 'picked_date', 'returned_date','deposite_amount', 'deposite_status', 'order_status','rent_amount','waist','hip','chest','payment_status','picked_up','complete_order','extra_amount', 'status','cancellation_charges','return_amount','cancel_flag','earning_amount','other_charges','pending_amount','postpond','issues_penalty','issues_reason','carry_frwd_app', 'remark', 'updated_time', 'updated_time_temp', 'gpay_number'], 'safe'],
            [['net_value', 'discount', 'deposite_amount'], 'number'],
            [['deposite_applicable',  'customer_id'], 'integer'],
            [['deposite_status', 'order_status', 'status'], 'string'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerMaster::className(), 'targetAttribute' => ['customer_id' => 'id']],
            ['return_date', 'validateReturnDate'],
        ];
    }

    /**
     * Custom validation to ensure return_date is greater than or equal to pickup_date
     */
    public function validateReturnDate($attribute, $params)
    {
        if (!empty($this->pickup_date) && !empty($this->return_date)) {
            $pickup = strtotime($this->pickup_date);
            $return = strtotime($this->return_date);
            
            if ($return < $pickup) {
                $this->addError($attribute, 'Return Date must be greater than or equal to Pickup Date.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'booking_id' => 'Booking ID',
            'booking_date' => 'Booking Date',
            'event_date' => 'Event Date',
            'pickup_date' => 'Pickup Date',
            'picked_date' => 'Picked Date',
            'return_date' => 'Return Date',
            'returned_date' => 'Returned Date',
            'cancel_flag' => 'Cancel Booking',
            'net_value' => 'Net Value',
            'rent_amount' => 'Rent Amount',
            'discount' => 'Discount',
            'deposite_applicable' => 'Deposite Applicable',
            'deposite_amount' => 'Deposite Amount',
            'payment_status' => 'Payment Status',
            'customer_id' => 'Customer ID',
            'deposite_status' => 'Deposite Status',
            'diplay_amount' => 'Default',
            'picked_up' => 'Picked',
            'order_status' => 'Order Status',
            'status' => 'Status',
             'chest' => 'Chest',
             'remark' => 'Enter Remark',
             'hip' => 'Hand',
             'waist' => 'Waist',
             'carry_frwd_app' => 'Apply Carry Forward',
             'issues_penalty' => 'Penality Amount',
             'issues_reason' => 'Issue Reason',
             'updated_time' => 'Updated Time',
             'gpay_number' => 'GPay Nos.',


        ];
    }
public function init()

    {
        parent::init();
        $this->cancellation_charges = 0;
        $this->return_amount = 0;
        $this->other_charges = 0;

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerMaster::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingItems()
    {
        return $this->hasMany(BookingItem::className(), ['booking_id' => 'booking_id']);
    }

    public function getBookingItemsInv()
    {
        return $this->hasMany(BookingItem::className(), ['booking_id' => 'booking_id'])->andWhere(['inv_visibilty' =>
          0]);
    }
    public function getPayment()
    {
        return $this->hasMany(PaymentMaster::className(), ['booking_id' => 'booking_id']);
    }
    public static function getTotal($provider, $columnName)
{
    $total = 0;
    foreach ($provider as $item) {
      $total += $item[$columnName];
  }
  return number_format($total);  
}
    public static function getTotalPending($provider)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += ($item['net_value']-$item['paid_amount']);
        }
        return number_format($total);
    }
}
