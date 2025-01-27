<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_item".
 *
 * @property int $item_no
 * @property int $purhcase_id
 * @property int $item_code
 * @property string $net_value
 * @property int $item_type
 * @property int $item_category
 * @property string $item_image
 *
 * @property PurchaseHeader $purhcase
 * @property CategoryMaster $itemCategory
 * @property TypeMaster $itemType
 */
class PurchaseItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $item_name,$deposit_amount,$rent_amount;
    public static function tableName()
    {
        return 'purchase_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'item_name', 'net_value','item_code'], 'required'],
            [['purhcase_id', 'item_code', 'item_type', 'item_category'], 'integer'],
            [['net_value'], 'number'],
            [['purhcase_id','item_code', 'item_type', 'item_category','rent_amount','image'], 'safe'],
            [['item_image'], 'string', 'max' => 120],
            [['purhcase_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseHeader::className(), 'targetAttribute' => ['purhcase_id' => 'id']],
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
            'item_no' => 'Item No',
            'image' => 'Attachment',
            'purhcase_id' => 'Purhcase ID',
            'item_code' => 'Item Code',
            'net_value' => 'Purchase Amount',
            'item_type' => 'Item Type',
            'item_category' => 'Item Category',
            'item_image' => 'Item Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurhcase()
    {
        return $this->hasOne(PurchaseHeader::className(), ['id' => 'purhcase_id']);
    }
    public function getItem()
    {
        return $this->hasOne(ItemMaster::className(), ['id' => 'item_code']);
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
