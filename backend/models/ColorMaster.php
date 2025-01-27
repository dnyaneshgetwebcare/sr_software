<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "color_master".
 *
 * @property int $id
 * @property string $name
 * @property string $image_path
 *
 * @property ItemMaster[] $itemMasters
 */
class ColorMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 25],
            [['image_path'], 'string', 'max' => 150],
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
            'image_path' => 'Image Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemMasters()
    {
        return $this->hasMany(ItemMaster::className(), ['colour_cat' => 'id']);
    }
}
