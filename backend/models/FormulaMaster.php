<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "formula_master".
 *
 * @property int $category_id
 * @property int $receiver_name
 * @property string $receiver_per
 *
 * @property CategoryMaster $category
 * @property ReceiverMaster $receiverName
 */
class FormulaMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formula_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'receiver_name'], 'required'],
            [['category_id', 'receiver_name'], 'integer'],
            [['receiver_per'], 'number'],
            [['category_id', 'receiver_name'], 'unique', 'targetAttribute' => ['category_id', 'receiver_name']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['receiver_name'], 'exist', 'skipOnError' => true, 'targetClass' => ReceiverMaster::className(), 'targetAttribute' => ['receiver_name' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'receiver_name' => 'Receiver Name',
            'receiver_per' => 'Receiver Per',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryMaster::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiverName()
    {
        return $this->hasOne(ReceiverMaster::className(), ['id' => 'receiver_name']);
    }
}
