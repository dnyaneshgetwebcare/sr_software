<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer_master".
 *
 * @property int $id
 * @property string $name
 * @property string $email_id
 * @property string $contact_nos
 * @property string $contact_nos_2
 * @property string $address
 * @property string $reference
 * @property string $reference_name
 * @property string $created_date
 * @property string $cust_group
 *
 * @property BookingHeader[] $bookingHeaders
 */
class CustomerMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'contact_nos', 'reference', 'address_group'], 'required'],
            [['reference', 'cust_group'], 'string'],
            [['created_date','id','contact_nos_2','cust_group','created_on'], 'safe'],
            [['email_id'],'email'],
            [['name', 'email_id', 'reference_name'], 'string', 'max' => 150],
           // [['contact_nos', 'contact_nos_2'], 'string', 'length' => 10],
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
            'name' => 'Name',
            'email_id' => 'Email ID',
            'contact_nos' => 'Contact Nos',
            'contact_nos_2' => 'Contact Nos 2',
            'address' => 'Address',
            'reference' => 'Reference',
            'reference_name' => 'Reference Name',
            'created_date' => 'Created Date',
            'cust_group' => 'Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingHeaders()
    {
        return $this->hasMany(BookingHeader::className(), ['customer_id' => 'id']);
    }
}
