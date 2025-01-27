<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expense_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property ExpenseHeader[] $expenseHeaders
 */
class ExpenseType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseHeaders()
    {
        return $this->hasMany(ExpenseHeader::className(), ['expense_type' => 'id']);
    }
}
