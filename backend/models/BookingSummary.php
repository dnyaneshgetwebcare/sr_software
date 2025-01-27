<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "booking_summary".
 *
 * @property int $month
 * @property int $year
 * @property int $item_no
 * @property string $pending_amount
 * @property string $amount
 */
class BookingSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'year'], 'required'],
            [['month', 'year', 'item_no'], 'integer'],
            [['pending_amount', 'amount'], 'number'],
            [['month', 'year'], 'unique', 'targetAttribute' => ['month', 'year']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'month' => 'Month',
            'year' => 'Year',
            'item_no' => 'Item No',
            'pending_amount' => 'Pending Amount',
            'amount' => 'Amount',
        ];
    }
}
