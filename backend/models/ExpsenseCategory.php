<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expsense_category".
 *
 * @property int $id
 * @property string $name
 * @property int $items_status
 *
 * @property ExpenseHeader[] $expenseHeaders
 */
class ExpsenseCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expsense_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['items_status'], 'integer'],
            [['name'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'items_status' => 'Items Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseHeaders()
    {
        return $this->hasMany(ExpenseHeader::className(), ['expense_category' => 'id']);
    }
}
