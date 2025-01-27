<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_master_img".
 *INSERT INTO `item_master_img`(`item_id`, `img_name`, `default_image`) SELECT `id`,`images`,1 FROM `item_master` where `images` is not null
 * @property int $id
 * @property int $item_id
 * @property string $img_name
 * @property int $status
 * @property int $default_image
 */
class ItemMasterImg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_master_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'img_name'], 'required'],
            [['item_id', 'status','default_image'], 'integer'],
            [['img_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'img_name' => 'Img Name',
            'status' => 'Status',
        ];
    }
}
