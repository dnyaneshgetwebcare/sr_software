<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vendor_master".
 *
 * @property int $id
 * @property string $name
 * @property string $email_id
 * @property string $contact_nos
 * @property string $group_id
 * @property string $address
 * @property string $status
 *
 * @property ItemMaster[] $itemMasters
 */
class VendorMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['group_id', 'status'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['email_id'], 'string', 'max' => 250],
            [['contact_nos'], 'string', 'max' => 15],
            [['address'], 'string', 'max' => 350],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Vendor Name',
            'email_id' => 'Email ID',
            'contact_nos' => 'Contact Nos',
            'group_id' => 'Group ID',
            'address' => 'Address',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemMasters()
    {
        return $this->hasMany(ItemMaster::className(), ['vendor_id' => 'id']);
    }
}
