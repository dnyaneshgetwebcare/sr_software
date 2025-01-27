<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_summary".
 *
 * @property int $month
 * @property int $year
 * @property int $item_type
 * @property int $item_category
 * @property string $rent_amount
 * @property string $expense_amount
 * @property int $number_of_time_rented
 *
 * @property CategoryMaster $itemCategory
 * @property TypeMaster $itemType
 */
class ItemSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'year', 'item_type', 'item_category'], 'required'],
            [['month', 'year', 'item_type', 'item_category', 'number_of_time_rented'], 'integer'],
            [['rent_amount', 'expense_amount'], 'number'],
            [['month', 'year', 'item_type', 'item_category'], 'unique', 'targetAttribute' => ['month', 'year', 'item_type', 'item_category']],
            [['item_category'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['item_category' => 'id']],
            [['item_type'], 'exist', 'skipOnError' => true, 'targetClass' => TypeMaster::className(), 'targetAttribute' => ['item_type' => 'id']],
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
            'item_type' => 'Item Type',
            'item_category' => 'Item Category',
            'rent_amount' => 'Rent Amount',
            'expense_amount' => 'Expense Amount',
            'number_of_time_rented' => 'Number Of Time Rented',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCategory()
    {
        return $this->hasOne(CategoryMaster::className(), ['id' => 'item_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemType()
    {
        return $this->hasOne(TypeMaster::className(), ['id' => 'item_type']);
    }
}
