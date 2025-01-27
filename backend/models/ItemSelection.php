<?php
namespace backend\models;
use yii\helpers\ArrayHelper;

use Yii;
class ItemSelection extends \yii\base\Model
{
	public $item_type,$item_id,$description,$item_category,$rent_amount,$deposit_amount;
  public function rules()
    {
    	 return [
            [['item_type', 'material_no'], 'required'],];
    }

 public function attributeLabels()
    {
        return [];
	}
}