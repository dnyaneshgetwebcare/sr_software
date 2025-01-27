<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_header".
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $purchase_date
 * @property string $purchase_amount
 * @property string $discount
 * @property int $location
 *
 * @property VendorMaster $vendor
 * @property PurchaseItem[] $purchaseItems
 */
class PurchaseHeader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_header';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_date'], 'required'],
            [['id', 'vendor_id', 'location'], 'integer'],
            [['purchase_date','id', 'vendor_id'], 'safe'],
            [['purchase_amount', 'discount'], 'number'],
            [['id'], 'unique'],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorMaster::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor ID',
            'purchase_date' => 'Purchase Date',
            'purchase_amount' => 'Purchase Amount',
            'discount' => 'Discount',
            'location' => 'Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(VendorMaster::className(), ['id' => 'vendor_id']);
    }
   public function getImageurl()
   {
       if($this->image!=''){
         return \Yii::$app->request->BaseUrl.'/purchase/'.$this->image;
        }else{
          return \Yii::$app->request->BaseUrl.'/img/no-image.jpg';
       }
   }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseItems()
    {
        return $this->hasMany(PurchaseItem::className(), ['purhcase_id' => 'id']);
    }
    public static function getTotal($provider, $columnName)
    {
    $total = 0;
     foreach ($provider as $item) {
      $total += $item[$columnName];
     }
     return number_format($total);  
    }
}
