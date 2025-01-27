<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category_master".
 *
 * @property int $id
 * @property string $name
 *
 * @property TypeMaster[] $typeMasters
 */
class CategoryMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_master';
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
      public function Formula($receiver_name)
    {
        $formula_per=FormulaMaster::find()->where(['receiver_name' => $receiver_name,'category_id'=>$this->id])->one();
        return ($formula_per=='')?0:$formula_per->receiver_per;
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
   public function earningByCategory($month_year)
    {
        /*$formula_per=FormulaMaster::find()->where(['receiver_name' => $this->id,'category_id'=>$category_id])->one();*/
        $booking_id=BookingHeader::find()->select('booking_id')->where(['order_status'=>array('Open','Closed','Cancelled')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "'. $month_year.'"');
         $cat_earning=BookingItem::find()->select(['sum(earning_amount) as total_rent'])->where(['booking_id'=>$booking_id,'category_id'=>$this->id])->joinWith('item')->createCommand()->queryOne();

       return ($cat_earning['total_rent']!='')?$cat_earning['total_rent']:0;

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeMasters()
    {
        return $this->hasMany(TypeMaster::className(), ['category_id' => 'id']);
    }
}
