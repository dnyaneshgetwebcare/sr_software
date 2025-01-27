<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_master".
 *
 * @property int $id
 * @property string $item_code
 * @property string $name
 * @property string $details
 * @property int $type_id
 * @property int $category_id
 * @property string $size
 * @property string $purchase_date
 * @property string $purchase_amount
 * @property string $rent_amount
 * @property string $deposit_amount
 * @property int $vendor_id
 * @property string $scrab_status
 * @property int $rent_times
 * @property string $expense_amount
 * @property string $item_status
 * @property int $colour_cat
 * @property int $nos_dry_cleaning
 *
 * @property ColorMaster $colourCat
 * @property ItemMaster $type
 * @property ItemMaster[] $itemMasters
 * @property CategoryMaster $category
 * @property VendorMaster $vendor
 */
class ItemMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
   // public $images;
    public static function tableName()
    {
        return 'item_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'name', 'details', 'type_id', 'category_id',  'rent_amount', 'deposit_amount'], 'required'],
            [[  'purchase_date', 'purchase_amount'], 'required','on'=>'create_new'],
            [['type_id', 'category_id', 'vendor_id', 'rent_times', 'colour_cat', 'nos_dry_cleaning'], 'integer'],
            [['purchase_date', 'vendor_id', 'scrab_status', 'rent_times', 'expense_amount','item_code','images','occasion_master','display_type','skip_website'], 'safe'],
            [['rent_times','rent_amount', 'deposit_amount', 'nos_dry_cleaning', 'expense_amount'], 'default', 'value'=> 0],
            [['purchase_amount', 'rent_amount', 'deposit_amount', 'expense_amount'], 'number'],
            [['scrab_status', 'item_status'], 'string'],
            [['item_code'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 150],
            [['details'], 'string', 'max' => 250],
            [['size'], 'string', 'max' => 50],
            [['item_code'], 'unique'],
            [['colour_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ColorMaster::className(), 'targetAttribute' => ['colour_cat' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeMaster::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'item_code' => 'Item Code',
            'name' => 'Name',
            'details' => 'Details',
            'type_id' => 'Type',
            'category_id' => 'Category',
            'size' => 'Size',
            'purchase_date' => 'Purchase Date',
            'purchase_amount' => 'Purchase Amount',
            'rent_amount' => 'Rent Amount',
            'deposit_amount' => 'Deposit Amount',
            'vendor_id' => 'Vendor Name',
            'scrab_status' => 'Scrab Status',
            'rent_times' => 'Rent Times',
            'expense_amount' => 'Expense Amount',
            'item_status' => 'Item Status',
            'colour_cat' => 'Colour',
            'images' => 'Images',
            'occasion_master' => 'Occasion',
            'display_type' => 'Display Under',
            'nos_dry_cleaning' => 'Nos Dry Cleaning',
            'skip_website' => 'Hide in website',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColourCat()
    {
        return $this->hasOne(ColorMaster::className(), ['id' => 'colour_cat']);
    }
public function getImageurl()
{
    if($this->images!=''){
return \Yii::$app->request->BaseUrl.'/uploads/'.$this->images;
}else{
    return \Yii::$app->request->BaseUrl.'/img/no-image.jpg';
}
}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TypeMaster::className(), ['id' => 'type_id']);
    }
    public function getNextCode()
   {
   $type_master=$this->type;
   $type_master->curent_number=$type_master->curent_number+1;
   $type_master->save(false);
   return $type_master->intial_pre.''.str_pad($type_master->curent_number, 4, '0', STR_PAD_LEFT);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getItemMasters()
    {
        return $this->hasMany(ItemMaster::className(), ['type_id' => 'id']);
    }*/

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
    public function getVendor()
    {
        return $this->hasOne(VendorMaster::className(), ['id' => 'vendor_id']);
    }
}
