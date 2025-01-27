<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "type_master".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $intial_pre
 * @property int $curent_number
 *
 * @property BookingItem[] $bookingItems
 * @property ItemMaster[] $itemMasters
 * @property PurchaseItem[] $purchaseItems
 * @property CategoryMaster $category
 */
class TypeMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id','intial_pre','dispaly_main_site'], 'required'],
            [['category_id', 'curent_number','dispaly_main_site'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['intial_pre'], 'string', 'max' => 5],
            [['intial_pre'], 'unique'],
            [['dispaly_main_site'], 'default','value'=>0],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category',
            'intial_pre' => 'Intial',
            'dispaly_main_site' => 'Hide Website',
            'curent_number' => 'Curent Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingItems()
    {
        return $this->hasMany(BookingItem::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemMasters()
    {
        return $this->hasMany(ItemMaster::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseItems()
    {
        return $this->hasMany(PurchaseItem::className(), ['item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryMaster::className(), ['id' => 'category_id']);
    }
}
