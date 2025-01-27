<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_carry_frd".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $booking_id
 * @property float $carry_return
 * @property float $carry_balance
 * @property float $total_bal
 * @property int $status
 * @property string $created_by
 * @property string $created_at
 * @property string $entry_time
 */
class BookingCarryFrd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking_carry_frd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'customer_id', 'booking_id',  'created_at', 'entry_time'], 'required'],
            [['id', 'customer_id', 'booking_id', 'status'], 'integer'],
            [['carry_return', 'carry_balance', 'total_bal'], 'number'],
            [['created_at', 'entry_time'], 'safe'],
            [['created_by'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'booking_id' => 'Booking ID',
            'carry_return' => 'Carry Return',
            'carry_balance' => 'Carry Balance',
            'total_bal' => 'Total Bal',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'entry_time' => 'Entry Time',
        ];
    }
}
