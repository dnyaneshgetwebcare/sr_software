<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "display_type".
 *
 * @property int $id
 * @property string $name
 * @property string|null $deatils_type
 * @property int $status
 * @property int $main_screen_active
 */
class DisplayType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'display_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'main_screen_active','website'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['deatils_type'], 'string', 'max' => 500],
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
            'deatils_type' => 'Info',
            'status' => 'Status',
            'main_screen_active' => 'Show on main screen',
            'website' => 'Show on website',
        ];
    }
}
