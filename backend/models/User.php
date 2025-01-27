<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $contact_nos
 * @property string $user_type
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property string $login_status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord
{

  public $DATE_FORMAT;

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'user';
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['username',  'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
      [['status', 'created_at', 'updated_at'], 'integer'],
      [['user_type'], 'string'],

      [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],

      [['user_type'], 'string', 'max' => 20],
      [['auth_key'], 'string', 'max' => 32],


      [['email'], 'unique'],
      [['password_reset_token'], 'unique'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('yii', 'ID'),
      'username' => Yii::t('yii', 'Username'),

      'user_type' => Yii::t('yii', 'user_type'),
      'auth_key' => Yii::t('yii', 'Auth Key'),
      'password_hash' => Yii::t('yii', 'Password Hash'),
      'password_reset_token' => Yii::t('yii', 'Password Reset Token'),
      'email' => Yii::t('yii', 'Email'),
      'status' => Yii::t('yii', 'Status'),

      'created_at' => Yii::t('yii', 'Created At'),
      'updated_at' => Yii::t('yii', 'Updated At'),

    ];
  }

  public function setPassword($password)
  {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }

  public function generateAuthKey()
  {
    $this->auth_key = Yii::$app->security->generateRandomString();
  }
}
