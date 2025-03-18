<?php

namespace frontend\controllers;

use backend\models\BookingItem;
use backend\models\CustomerMaster;
use backend\models\ItemMaster;
use backend\models\VendItemMaster;
use backend\models\VendorMaster;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */



  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return mixed
   */
  public function actionIndex()
  {
    return $this->render('not_found');
  }

  /**
   * Logs in a user.
   *
   * @return mixed
   */
  public function actionLogin()
  {
    return $this->render('not_found');
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    } else {
      $model->password = '';

      return $this->renderPartial('login', [
        'model' => $model,
      ]);
    }
  }

  /**
   * Logs out the current user.
   *
   * @return mixed
   */
  public function actionLogout()
  {
    return $this->render('not_found');
    Yii::$app->user->logout();

    return $this->goHome();
  }

  public function actionItemList()
  {

  }

  /**
   * Displays contact page.
   *
   * @return mixed
   */
  public function actionContact()
  {
    return $this->render('not_found');
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
        Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
      } else {
        Yii::$app->session->setFlash('error', 'There was an error sending your message.');
      }

      return $this->refresh();
    } else {
      return $this->render('contact', [
        'model' => $model,
      ]);
    }
  }

  /**
   * Displays about page.
   *
   * @return mixed
   */
  public function actionAbout()
  {
      /*ALTER TABLE `booking_item` ADD `vendor_visiblity` INT(1) NOT NULL DEFAULT '1' AFTER `payment_status`;
      ALTER TABLE `vendor_master` CHANGE `group_id` `group_id` ENUM('None','Supplier','Dry Cleaning','Alteration','Sharing') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

      ALTER TABLE `vendor_master` ADD `encryption_id` VARCHAR(50) NULL AFTER `status`
      CREATE TABLE `soyara_rental`.`vend_item_master` (`id` INT(1) NOT NULL AUTO_INCREMENT , `item_id` INT(1) NOT NULL , `vendor_id` INT(1) NOT NULL , `status` ENUM('ACTIVE','DEACTIVATE') NOT NULL DEFAULT 'ACTIVE' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
      ALTER TABLE `vend_item_master` ADD FOREIGN KEY (`vendor_id`) REFERENCES `vendor_master`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `vend_item_master` ADD FOREIGN KEY (`item_id`) REFERENCES `item_master`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
      */
    if(!isset($_GET['encryption_id'])){
       return $this->render('not_found');
    }
      $encryption = $_GET['encryption_id'];
    try {
      $vendor_id = VendorMaster::find()->where(['encryption_id' => $encryption])->one()->id;
      /*$items = VendItemMaster::find()->select('item_id')->where(['vendor_id' => $vendor_id])->createCommand()->queryAll();*/
      //$items = ArrayHelper::getColumn($items, 'item_id');

      $itemmaster = ItemMaster::find()->where(['vendor_id' => $vendor_id])->asArray()->all();
      $items = ArrayHelper::getColumn($itemmaster, 'id');
      $item_by_type = ArrayHelper::index($itemmaster, null, 'category_id');
      $mens = isset($item_by_type[1]) ? count($item_by_type[1]) : 0;
      $womens = isset($item_by_type[2]) ? count($item_by_type[2]) : 0;
      $jewellary = isset($item_by_type[3]) ? count($item_by_type[3]) : 0;
      $booking_items = BookingItem::find()->select(['booking_header.booking_date', 'booking_header.pickup_date', 'booking_header.return_date', 'booking_header.customer_id', 'booking_header.order_status', 'product_id', 'customer_master.name as customer_name', 'booking_item.amount', 'booking_item.discount', 'booking_item.earning_amount', 'booking_header.status'])->leftJoin('booking_header', 'booking_header.booking_id = booking_item.booking_id')->leftJoin('customer_master', 'booking_header.customer_id = customer_master.id')->where(['product_id' => $items, 'booking_header.order_status' => ['Open', 'Closed'], 'vendor_visiblity' => 1])->orderBy(['booking_header.pickup_date' => SORT_DESC])->createCommand()->queryAll();
      $booking_details = ArrayHelper::index($booking_items, null, 'product_id');
    }catch (Exception $e){
      return $this->render('not_found');
    }catch (ErrorException $ee){
       return $this->render('not_found');
    }

    return $this->render('about', ['item_master' => $itemmaster, 'booking_details' => $booking_details, 'mens' =>
      $mens, 'women'=> $womens, 'jewellary' => $jewellary]);
  }

  /**
   * Signs user up.
   *
   * @return mixed
   */
  public function actionSignup()
  {
    return $this->render('not_found');
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post()) && $model->signup()) {
      Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
      return $this->goHome();
    }

    return $this->render('signup', [
      'model' => $model,
    ]);
  }

  /**
   * Requests password reset.
   *
   * @return mixed
   */
  public function actionRequestPasswordReset()
  {
    return $this->render('not_found');
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

        return $this->goHome();
      } else {
        Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
      }
    }

    return $this->render('requestPasswordResetToken', [
      'model' => $model,
    ]);
  }

  /**
   * Resets password.
   *
   * @param string $token
   * @return mixed
   * @throws BadRequestHttpException
   */
  public function actionResetPassword($token)
  {
    return $this->render('not_found');
    try {
      $model = new ResetPasswordForm($token);
    } catch (InvalidArgumentException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
      Yii::$app->session->setFlash('success', 'New password saved.');

      return $this->goHome();
    }

    return $this->render('resetPassword', [
      'model' => $model,
    ]);
  }

  /**
   * Verify email address
   *
   * @param string $token
   * @return yii\web\Response
   * @throws BadRequestHttpException
   */
  public function actionVerifyEmail($token)
  {
    return $this->render('not_found');
    try {
      $model = new VerifyEmailForm($token);
    } catch (InvalidArgumentException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }
    if ($user = $model->verifyEmail()) {
      if (Yii::$app->user->login($user)) {
        Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
        return $this->goHome();
      }
    }

    Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
    return $this->goHome();
  }

  /**
   * Resend verification email
   *
   * @return mixed
   */
  public function actionResendVerificationEmail()
  {
    return $this->render('not_found');
    $model = new ResendVerificationEmailForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
        return $this->goHome();
      }
      Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
    }

    return $this->render('resendVerificationEmail', [
      'model' => $model
    ]);
  }
}
