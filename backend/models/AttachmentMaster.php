<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "attachment_master".
 *
 * @property int $id
 * @property string $object_type
 * @property int $object_key
 * @property string $file_path
 */
class AttachmentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachment_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_type', 'object_key', 'file_path'], 'required'],
            [['object_type'], 'string'],
            [['object_key'], 'integer'],
            [['file_path'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_type' => 'Object Type',
            'object_key' => 'Object Key',
            'file_path' => 'File Path',
        ];
    }
}
