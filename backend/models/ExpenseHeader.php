<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expense_header".
 *
 * @property int $id
 * @property string $expense_date
 * @property int $expense_category
 * @property string $expense_amount
 * @property string $remark
 * @property string $image_url
 * @property int $vendor_id
 * @property string $name
 * @property string $contact_nos
 * @property string $address
 * @property int $delete_status
 *
 * @property VendorMaster $vendor
 * @property ExpsenseCategory $expenseCategory
 */
class ExpenseHeader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense_header';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense_date', 'expense_category'], 'required'],
            [['expense_date'], 'safe'],
            [['expense_category', 'vendor_id', 'delete_status'], 'integer'],
            [['expense_amount'], 'number'],
            [['remark', 'address'], 'string'],
            [['image_url'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['contact_nos'], 'string', 'max' => 10],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorMaster::className(), 'targetAttribute' => ['vendor_id' => 'id']],
            [['expense_category'], 'exist', 'skipOnError' => true, 'targetClass' => ExpsenseCategory::className(), 'targetAttribute' => ['expense_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expense_date' => 'Expense Date',
            'expense_category' => 'Expense Category',
            'expense_amount' => 'Expense Amount',
            'remark' => 'Remark',
            'image_url' => 'Image Url',
            'vendor_id' => 'Vendor ID',
            'name' => 'Name',
            'contact_nos' => 'Contact Nos',
            'address' => 'Address',
            'delete_status' => 'Delete Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(VendorMaster::className(), ['id' => 'vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseCategory()
    {
        return $this->hasOne(ExpsenseCategory::className(), ['id' => 'expense_category']);
    }
     public function getExpenseItem()
    {
        return $this->hasOne(ExpenseItem::className(), ['expense_id' => 'id']);
    }
}
