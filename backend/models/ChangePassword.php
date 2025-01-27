<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\UserConfig;


/**
 * Signup form
 */
class ChangePassword extends Model
{

     public $password;
     public $confirm_password;
     public $oldpass;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Password & Confirm Password not match" ], 
            [['password'], 'required'],
            // [['oldpass'],'findPasswords'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'required'],
            ['confirm_password', 'string', 'min' => 6],
            
        ];
    }


    // public function findPasswords($attribute, $params){     
           
    //         if(!$this->verifyPassword($this->oldpass)){
    //             $this->addError($attribute,'Old password is incorrect');
    //         }
              
    //     }

   public function verifyPassword($password){
     $user = User::find()->where([
                'username'=>Yii::$app->user->identity->username
            ])->one();
     $dbpassword= $user->password_hash;
     return Yii::$app->security->validatePassword($password,$dbpassword);
   }
     public function attributeLabels()
    {
        return [
            // 'oldpass' => 'Old Password',
            
        ];
    }
        

}
