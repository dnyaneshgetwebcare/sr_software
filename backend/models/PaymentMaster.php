<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "payment_master".
 *
 * @property int $payment_id
 * @property string $date
 * @property string $type
 * @property string $mode_of_payment
 * @property string $received_by
 * @property string $received_during
 * @property string $dom
 * @property int $amount
 * @property int $booking_id
 * @property string $sendto
 */
class PaymentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type', 'mode_of_payment', 'received_by', 'received_during', 'amount', 'sendto'], 'required'],
            [['date', 'dom', 'booking_id','payment_id','remark'], 'safe'],
            [['type', 'mode_of_payment', 'received_by', 'received_during', 'sendto'], 'string'],
            [['amount', 'booking_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => 'Payment ID',
            'date' => 'Date',
            'type' => 'Type',
            'mode_of_payment' => 'Mode Of Payment',
            'received_by' => 'Received By',
            'received_during' => 'Received During',
            'dom' => 'Dom',
            'amount' => 'Amount',
            'booking_id' => 'Booking ID',
            'sendto' => 'Sendto',
        ];
    }
     public function getBooking()
    {
        return $this->hasOne(BookingHeader::className(), ['booking_id' => 'booking_id']);
    }
    public static function getTotal($models,$column_key)
    {
        # code...
        $result=0;
        $bookid=null;
        foreach ($models as $key => $model) {
            # code...
            if($model['booking_id']!=$bookid){
                if($column_key!='total_earn'){
                    $result+=$model[$column_key];
                }else{
                    $total_ern=(($model['rent_amount']-$model['discount']) +$model['cancellation_charges']+$model['other_charges']+$model['extra_amount']-$model['issues_penalty']);
                    $result+=$total_ern;
                }
                 
                 $bookid=$model['booking_id'];
            }
           
        }
        return number_format($result);
    }
}
