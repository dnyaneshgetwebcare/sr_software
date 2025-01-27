<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "receiver_master".
 *
 * @property int $id
 * @property string $name
 * @property int $c_d_ind
 *
 * @property FormulaMaster[] $formulaMasters
 * @property CategoryMaster[] $categories
 */
class ReceiverMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receiver_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'c_d_ind'], 'required'],
            [['c_d_ind'], 'integer'],
            [['name'], 'string', 'max' => 25],
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
            'c_d_ind' => 'C D Ind',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormulaMasters()
    {
        return $this->hasMany(FormulaMaster::className(), ['receiver_name' => 'id']);
    }
       public function Formula($category_id)
    {
        $formula_per=FormulaMaster::find()->where(['receiver_name' => $this->id,'category_id'=>$category_id])->one();
        return ($formula_per=='')?0:$formula_per->receiver_per;
    }

 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(CategoryMaster::className(), ['id' => 'category_id'])->viaTable('formula_master', ['receiver_name' => 'id']);
    }
}
