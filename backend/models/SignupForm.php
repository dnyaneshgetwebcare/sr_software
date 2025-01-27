<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\UserConfig;
use backend\models\AuthAssignment;

// use backend\models\ERPOtherUsers;


/**
 * Signup form
 */
class SignupForm extends Model
{
  public $username;
  public $email;
  public $password;
  public $confirm_password;
  public $name;
  public $contact_nos;
  public $role;
  public $lang;
  public $sys_start_date;
  public $timezone;


  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      ['username', 'trim'],
      [['username', 'email', 'name', 'password', 'confirm_password'], 'required'],
      ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
      ['username', 'string', 'min' => 2, 'max' => 10],
      ['email', 'trim'],
      ['email', 'email'],
      ['email', 'string', 'max' => 255],
      [['sys_start_date', 'timezone'], 'required', 'on' => 'first_singup_users'],
      //[['email'], 'unique', 'targetAttribute' => ['email']],
      ['email', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'Email ID already exists.'], //for same db
      //for different db

      ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Password & Confirm Password not match"],
      ['password', 'string', 'min' => 6],
      ['confirm_password', 'string', 'min' => 6],

    ];
  }

  /**
   * Signs user up.
   *
   * @return User|null the saved model or null if saving fails
   */
  public function attributeLabels()
  {
    //print_r($_COOKIE);die;
    // $lang=isset($_COOKIE['companyLang'])?strtoupper($_COOKIE['companyLang']):'EN';
    // switch ($lang) {
    // case 'AR':
    // return [
    // 'id' =>'هوية شخصية',
    // 'username' => 'اسم المستخدم',
    // 'auth_key' => 'مفتاح المصادقة',
    // 'password_hash' => 'Password Hash',
    // 'password_reset_token' => 'رمز اعادة كلمة المرور',
    // 'email' => 'البريد الإلكتروني',
    // 'status' => 'موقف',
    // 'created_at' => 'أنشئت في',
    // 'updated_at' => 'تم التحديث في',
    // 'password'=>'كلمه السر',
    // 'confirm_password'=>'تأكيد كلمة المرور',
    // 'name'=>'الاسم',
    // ];
    // break;

    // default:

    return [
      'id' => Yii::t('yii', 'ID'),
      'username' => Yii::t('yii', 'Username'),
      'auth_key' => Yii::t('yii', 'Auth Key'),
      'password_hash' => Yii::t('yii', 'Password Hash'),
      'password_reset_token' => Yii::t('yii', 'Password Reset Token'),
      'email' => Yii::t('yii', 'Email'),
      'status' => Yii::t('yii', 'Status'),
      'created_at' => Yii::t('yii', 'created At'),
      'updated_at' => Yii::t('yii', 'updated At'),
      'name' => Yii::t('yii', 'Name'),
      'password' => Yii::t('yii', 'Password'),
      'confirm_password' => Yii::t('yii', 'Confirm Password'),

    ];
    // break;
    // }
  }

  public function signup($not_first_user = 1)
  {
    /*echo "<pre>";print_r($this->validate());die;
    if(!$this->validate()) {
        return 'null';
    }else{
        return array('errors' => 'fail');
    }*/

      $transaction = Yii::$app->db->beginTransaction();

      $user = new User();

      $otp = rand(100000, 999999);
      //$user->name = $this->name;
      $user->username = $this->username;

      $user->email = $this->email;
    //  $user->contact_nos = $this->contact_nos;
    //  $user->otp = $otp;


      // $user->role='admin';
      $user->setPassword($this->password);
      $user->generateAuthKey();

      // $flag = $user->save();

      if (!$flag = $user->save()) {
        return array('flag' => $flag, 'errors' => $user->errors);
      }






    if ($flag) {
      $transaction->commit();


      return array('flag' => $flag, 'user' => $user);
    } else {
      $transaction->rollBack();

      return array('flag' => $flag, 'errors' => array('Something went wrong'));
    }
    return $flag ? $user : null;
    // }
  }

  private function getDsnAttribute($name, $dsn)
  {
    if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
      return $match[1];
    } else {
      return null;
    }
  }

  /*public function sendEmail($email,$name,$url)
  {
      $sendGrid = Yii::$app->sendGrid;
      $message = $sendGrid->compose('welcome', ['name' => $name, 'url'=>$url]);
      $message->setFrom('noreply@erphorizon.com')
          ->setTo($email)
          ->setSubject( "New Registration");
      $result = $message->send($sendGrid);
     return $result;

  }*/
  public function sendEmail($dbname)
  {
    /* @var $user User */
    $user = User::findOne(['status' => User::STATUS_ACTIVE, 'email' => $this->email]);

    $company_details = ERPCompany::find()->where(['database_name' => $dbname])->one();

    // $user['dbname']=$dbname;

    // if (!$user) {
    //     return false;
    // }

    // if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
    //     $user->generatePasswordResetToken();
    //     if (!$user->save()) {
    //         return false;
    //     }
    // }

    $sendGrid = Yii::$app->sendGrid;

    $message = $sendGrid->compose('registration', ['user' => $user, 'password' => $this->password, 'dbname' => $company_details['project_name'], 'company_details' => $company_details]);

    return ($message->setFrom('noreply@erphorizon.com')
      ->setTo($this->email)
      ->setSubject('Registration for ERPHORIZON')
      ->send($sendGrid));
  }


}
