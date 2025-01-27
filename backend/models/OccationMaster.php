<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "occation_master".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class OccationMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'occation_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status','main_screen_active','website'], 'integer'],
            [['details_occ'], 'safe'],
            [['name'], 'string', 'max' => 150],
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
            'status' => 'Status',
            'details_occ' => 'Info',
            'main_screen_active' => 'Show on First Page',
            'website' => 'Show on Website',
        ];
    }
}
