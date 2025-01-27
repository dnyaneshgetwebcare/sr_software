<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expense_item".
 *
 * @property int $expense_item_no
 * @property int $expense_id
 * @property string $description
 * @property string $remark
 * @property int $expense_category
 * @property int $item_id
 * @property string $amount
 * @property string $date
 * @property string $dom
 * @property int $delete_status
 * @property int $item_type
 * @property int $item_category
 *
 * @property ExpsenseCategory $expenseCategory
 * @property ItemMaster $item
 * @property TypeMaster $itemType
 */
class ExpenseItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'amount'], 'required'],
            [['expense_id', 'expense_category', 'item_id', 'delete_status', 'item_type', 'item_category'], 'integer'],
            [['remark'], 'string'],
            [['amount'], 'number'],
            [['date', 'dom'], 'safe'],
            [['description'], 'string', 'max' => 250],
            [['expense_category'], 'exist', 'skipOnError' => true, 'targetClass' => ExpsenseCategory::className(), 'targetAttribute' => ['expense_category' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemMaster::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['item_type'], 'exist', 'skipOnError' => true, 'targetClass' => TypeMaster::className(), 'targetAttribute' => ['item_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'expense_item_no' => 'Expense Item No',
            'expense_id' => 'Expense ID',
            'description' => 'Description',
            'remark' => 'Remark',
            'expense_category' => 'Expense Category',
            'item_id' => 'Item ID',
            'amount' => 'Amount',
            'date' => 'Date',
            'dom' => 'Dom',
            'delete_status' => 'Delete Status',
            'item_type' => 'Item Type',
            'item_category' => 'Item Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseCategory()
    {
        return $this->hasOne(ExpsenseCategory::className(), ['id' => 'expense_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(ItemMaster::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemType()
    {
        return $this->hasOne(TypeMaster::className(), ['id' => 'item_type']);
    }
}
