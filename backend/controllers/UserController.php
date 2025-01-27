<?php

namespace backend\controllers;

use Yii;
use backend\models\User;

use backend\models\UserSearch;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\SignupForm;
use backend\models\ChangePassword;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'actions' => ['login', 'error'],
            'allow' => true,
          ],
          [
            'actions' => ['logout', 'change-password', 'reset-password', 'config', 'cancel-subscription', 'change-package', 'transaction-details', 'view', 'create', 'delete', 'change-status', 'activate-subscription', 'update'],
            'allow' => true,
            'roles' => ['@'],
          ],
          [
            'actions' => ['logout', 'create', 'signup'],
            'allow' => true,
            'roles' => ['@'],
          ],
          [
            'actions' => ['logout', 'create', 'view'],
            'allow' => true,
            'roles' => ['@'],
          ],
          [
            'actions' => ['index'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],

      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['GET'],
        ],
      ],

    ];
  }
  // public function beforeAction($action){
  //     //$this->enableCsrfValidation = false;
  //     if($action->actionMethod!='actionCompany'){
  //         if((!isset($_COOKIE['companyCode'])) || $_COOKIE['companyCode']=='' || (isset($_GET['COMPANY_CODE']) && $_GET['COMPANY_CODE']!==$_COOKIE['companyCode'])){
  //             return $this->redirect('index.php?r=site/company',302)->send();
  //         }
  //     }
  //     return parent::beforeAction($action);
  // }

  /**
   * Lists all User models.
   * @return mixed
   */
  public function actionIndex()
  {
    //  $config=$this->getConfig();
    $searchModel = new UserSearch();

    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    // echo'<pre>';print_r($admin);die;
    //  $lang = strtoupper($_COOKIE['companyLang']);
    /* if($lang=='AR'){
         return $this->render('index_ar', [
             'searchModel' => $searchModel,
             'config'=>$config,
             'dataProvider' => $dataProvider,
         ]);
     } else {*/
    return $this->render('index', [
      'searchModel' => $searchModel,
      //'config'=>$config,
      'dataProvider' => $dataProvider,


    ]);
    //}
  }

  public function actionChangePassword($id)
  {

    $current_user = Yii::$app->user->identity->id;
    // $lang = strtoupper($_COOKIE['companyLang']);
    //  if($lang=='AR'){
    //        // $id=Yii::$app->user->identity->id;
    //        $model = $this->findModel($id);
    //        $model1= new ChangePassword();
    //        //echo "<pre>";print_r($model);die;
    // if ($model1->load(Yii::$app->request->post())  && Yii::$app->request->isAjax) {
    //       Yii::$app->response->format = Response::FORMAT_JSON;
    //              $result= ActiveForm::validate($model1);

    //         if($result!=null){
    //          return $result;
    //      }else{

    //           $model->setPassword($model1->password);
    //           $model->generateAuthKey();
    //          $model->save();
    //           if(strtoupper($_COOKIE['companyLang'])=='AR'){
    //              Yii::$app->getSession()->setFlash('success','تم تحديث كلمة السر بنجاح');
    //           }else{
    //              Yii::$app->getSession()->setFlash('success','Password Succesfully Update!');
    //           }

    //           if(Yii::$app->user->identity->id==$id){
    //            return 2;
    //          }
    //          return true;

    //      }

    //      }

    //      return $this->renderAjax('change_password_ar', [
    //       'model'=>$model1,'user_id'=>$id]);
    //  } else {
    // $id=Yii::$app->user->identity->id;
    $model = $this->findModel($id);
    $model1 = new ChangePassword();
    //echo "<pre>";print_r($model);die;
    if ($model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
      Yii::$app->response->format = Response::FORMAT_JSON;

      /*if (!Yii::$app->user->can("change_password") && $current_user != $model->id) {
        return array('errors' => array("You are not allow to perform this action"));
      }*/
      /*echo $current_user;
      echo Yii::$app->user->can("change_password");die;*/

//echo "<pre>";print_r($model);die;
      $transaction = Yii::$app->db->beginTransaction();
      $result = ActiveForm::validate($model1);

      if ($result != null) {
        return array('errors' => $result);

      } else {
        $model->setPassword($model1->password);
        $model->generateAuthKey();
        $flag = $model->save(false);

        if ($flag) {
          $transaction->commit();
          Yii::$app->getSession()->setFlash('success', [
            'type' => 'success',
            'duration' => 3000,
            'icon' => 'fa fa-users',
            'message' => 'Password Succesfully Update!',
            'title' => 'WELL_DONE',
            'positonY' => 'top',
            'positonX' => 'right'
          ]);
        }
        // else{
        //    echo "<pre>"; print_r($model);die;
        //    $transaction->rollBack();
        //    // return false;
        //  }


        // if(strtoupper($_COOKIE['companyLang'])=='AR'){
        //     Yii::$app->getSession()->setFlash('success','تم تحديث كلمة السر بنجاح');
        //  }else{
        //     Yii::$app->getSession()->setFlash('success','Password Succesfully Update!');
        //  }
        if (Yii::$app->user->identity->id == $id) {
          return 2;
        }
        return true;

      }

    }

    return $this->render('change_password', [
      'model' => $model1,  'user_id' => $id]);
    // }
  }

  public function actionResetPassword($id)
  {

    $lang = strtoupper($_COOKIE['companyLang']);
    if ($lang == 'AR') {
      $model = $this->findModel($id);
      $model1 = new ResetPassword();

      if ($model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ActiveForm::validate($model1);

        if ($result != null) {
          return $result;
        } else {
          $model->setPassword($model1->password);
          $model->generateAuthKey();

          $model->save();
          if (strtoupper($_COOKIE['companyLang']) == 'AR') {
            Yii::$app->getSession()->setFlash('success', 'تم تحديث كلمة السر بنجاح');
          } else {
            Yii::$app->getSession()->setFlash('success', 'Password Succesfully Update!');
          }


          if (Yii::$app->user->identity->id == $id) {
            return 2;
          }
          return true;
        }
      }
      return $this->renderAjax('reset_password_ar', ['model' => $model1, 'user_id' => $id]);
    } else {
      $model = $this->findModel($id);
      $model1 = new ResetPassword();

      if ($model1->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = ActiveForm::validate($model1);

        if ($result != null) {
          return $result;
        } else {
          $model->setPassword($model1->password);
          $model->generateAuthKey();

          $model->save();
          if (strtoupper($_COOKIE['companyLang']) == 'AR') {
            Yii::$app->getSession()->setFlash('success', 'تم تحديث كلمة السر بنجاح');
          } else {
            Yii::$app->getSession()->setFlash('success', 'Password Succesfully Update!');
          }


          if (Yii::$app->user->identity->id == $id) {
            return 2;
          }
          return true;
        }
      }
      return $this->renderAjax('reset_password', ['model' => $model1, 'user_id' => $id]);
    }
  }

  public function actionSignup()
  {
    // $lang = strtoupper($_COOKIE['companyLang']);
    $model = new SignupForm();

    // $model->setScenario('new_users');
    if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      //$model->scenario = 'new_users';
      $result = ActiveForm::validate($model);

      if ($result != null) {
        // print_r($model);die;
        return array('errors' => $result);
      } else {
        $retrun_sign_up = $model->signup();

        if ($retrun_sign_up['flag']) {
          $user = $retrun_sign_up['user'];
          // if (Yii::$app->getUser()->login($user)) {
          // return $this->goHome();
          // }
          //  return $this->Login();
          // return $this->redirect(['login']);
          return array('user_id' => $user->id);
        } else {
          $errors = $retrun_sign_up['errors'];
          //   return $this->renderAjax('user_form', [
          // 'model' => $model,   ]);
          return array('errors' => $errors);
        }
      }
    }

    /*if($lang=='AR'){  
      return $this->renderAjax('user_form_ar', [
        'model' => $model,
      ]);
    } else {  */
    return $this->render('user_form', [
      'model' => $model,

    ]);
    // }
  }

  protected function getConfig()
  {
    $result = UserConfig::find()->select(['user_limit'])->where(['active_status' => 1])->one();
    $total_user = User::find()->select(['count(id) as id'])->where(['status' => 10])->one()->id;

    if (isset($result->user_limit)) {
      if ($total_user < $result->user_limit) {
        return true;
      } else {
        return false;
      }

    } else {
      return false;
    }

  }

  public function actionCancelSubscription()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    $dname = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
    $result = ERPCompany::find()->where(['database_name' => $dbname])->one();
    // print_r($result);die;
    $result->subscription_status = 0;
    $erp_user_sub = ERPSubscriptionTransaction::find()->where(['company_id' => $result->company_id, 'sub_status' => 1])->one();

    // print_r($erp_user_sub);die;


    if ($erp_user_sub != null) {
      // $erp_transaction=ERPTransactions::find()->where(['agreement_id'=>$erp_user_sub->transaction_id,'company_id'=>$result->company_id])->orderBy(['id'=>SORT_DESC])->one();
      $package_details = ERPPackage::find()->where(['package_id' => $erp_user_sub->package])->one();
      $erp_transaction = Yii::$app->PayPalRestApi->getAgreementDetails($erp_user_sub->transaction_id);

      if ($erp_transaction->state == 'Cancelled') {
        return array('error' => "You Cancelled Your subscription earlier.Hence you can't Deactivate");
      }
      $details = $this->suspendAgreement($erp_user_sub->transaction_id);
      $erp_user_sub->sub_status = 0;
      $erp_user_sub->save();

      $entry_transaction = new ERPTransactions();
      $entry_transaction->company_id = $result->company_id;
      $entry_transaction->transaction_status = 'subscription';
      $entry_transaction->payment_status = 'Suspended';
      $entry_transaction->amount = $package_details->amount;
      $entry_transaction->package = $package_details->package_id;
      $entry_transaction->transaction_id = rand();
      $entry_transaction->currency = 'USD';
      $entry_transaction->payer_id = $erp_user_sub->payer_id;
      $entry_transaction->agreement_id = $erp_user_sub->transaction_id;
      // $entry_transaction->email = $erp_company->email;
      $entry_transaction->country = $result->country_code;
      $entry_transaction->date_of_payment = date('Y-m-d');
      $entry_transaction->save();


      // if(!$flag = $entry_transaction->save()){
      // $result_data[] = $entry_transaction->errors;
      // }
      $cancel_mail = ($this->sendEmail('cancelSubsription'));
    }


    // echo "<pre>";print_r($result);die;;
    if ($result->save()) {
      return 1;
    } else {
      return false;
    }

  }

  public function actionActivateSubscription()
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    $dname = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
    $result = ERPCompany::find()->where(['database_name' => $dbname])->one();
    // print_r($result);die;
    $result->subscription_status = 1;
    $erp_user_sub = ERPSubscriptionTransaction::find()->where(['company_id' => $result->company_id, 'sub_status' => 0])->one();

    // print_r($erp_user_sub);die;
    if ($erp_user_sub != null) {
      // $erp_transaction=ERPTransactions::find()->where(['agreement_id'=>$erp_user_sub->transaction_id,'company_id'=>$result->company_id])->orderBy(['id'=>SORT_DESC])->one();
      $erp_transaction = Yii::$app->PayPalRestApi->getAgreementDetails($erp_user_sub->transaction_id);
      $package_details = ERPPackage::find()->where(['package_id' => $erp_user_sub->package])->one();
      // echo "<pre>";print_r($erp_transaction);die;
      if ($erp_transaction->state == 'Cancelled') {
        //  return $this->render('create', [
        //     'model' => $model,
        // ]);
        return array('error' => "You Cancelled Your subscription earlier.Hence you can't Activate/Deactivate");
      }
      $details = $this->reActiveAgreement($erp_user_sub->transaction_id);
      $erp_user_sub->sub_status = 1;
      $erp_user_sub->save();

      $entry_transaction = new ERPTransactions();
      $entry_transaction->company_id = $result->company_id;
      $entry_transaction->transaction_status = 'subscription';
      $entry_transaction->payment_status = 'Re-Activate';
      $entry_transaction->amount = $package_details->amount;
      $entry_transaction->package = $package_details->package_id;
      $entry_transaction->transaction_id = rand();
      $entry_transaction->currency = 'USD';
      $entry_transaction->payer_id = $erp_user_sub->payer_id;
      $entry_transaction->agreement_id = $erp_user_sub->transaction_id;
      // $entry_transaction->email = $erp_company->email;
      $entry_transaction->country = $result->country_code;
      $entry_transaction->date_of_payment = date('Y-m-d');
      $entry_transaction->save();
      //echo "<pre>";print_r($entry_transaction);die;
      $cancel_mail = ($this->sendEmail('reactiveSubsription'));
    }


    // echo "<pre>";print_r($result);die;;
    if ($result->save()) {
      return 1;
    } else {
      return false;
    }
  }

  public function reActiveAgreement($agreement_id)
  {
    $reactive_agree = Yii::$app->PayPalRestApi->reActive($agreement_id);
    return $reactive_agree;

  }

  public function suspendAgreement($agreement_id)
  {
    $suspended_agree = Yii::$app->PayPalRestApi->suspendAgreement($agreement_id);
    return $suspended_agree;

  }

  public function actionTransactionDetails()
  {
    $lang = strtoupper($_COOKIE['companyLang']);

    $json = array();
    $dname = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
    // $erp_user=ERPUser::find()->where(['email'=>$user->email])->one();
    $erp_user = ERPCompany::find()->where(['database_name' => $dbname])->one();
    $transactions = ERPTransactions::find()->joinwith(['packageDetails'])->where(['company_id' => $erp_user->company_id])->all();

    return $this->renderAjax('transaction_details', [
      'transactions' => $transactions,
      'model_labels' => $model_labels]);
  }

  public function actionChangePackage()
  {
    $lang = strtoupper($_COOKIE['companyLang']);
    if ($lang == 'AR') {
      $json = array();
      $packageModel = new PackageHistory();
      $company_country = Company::find()->select(['COUNTRY_CODE'])->one()->COUNTRY_CODE;
      $country_id = ERPCountry::find()->select(['country_id'])->where(['country_code' => $company_country])->createCommand()->queryOne()['country_id'];
      // $user=User::find()->orderBy(['id'=>SORT_ASC])->one();
      $dname = Yii::$app->getDb();
      $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
      //  $erp_user=ERPUser::find()->where(['email'=>$user->email])->one();
      $erp_user = ERPUser::find()->where(['db_name' => $dbname])->one();
      $ERPUserConfig = ERPUserConfig::find()->joinwith(['companyDetails'])->where(['company.user_id' => $erp_user->id])->one();
      $package_id = $ERPUserConfig->package_id;
      $user_limit = $ERPUserConfig->user_limit;
      // echo "<pre>";print_r($package_id);die;
      // $package_id=Transactions::find()->where(['user_id'=>$erp_user->id])->orderby(['id'=>SORT_DESC])->one()->package;


      if ($packageModel->load(Yii::$app->request->post())) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $active_user_count = User::find()->select(['count(id) as act_user'])->where(['status' => 10])->asArray()->one()['act_user'];
        $current_user_limit = Package::find()->where(['package_id' => $packageModel->new_package_id])->one()->user_limit;
        //echo "<pre>"; print_r($active_user_count);die;
        $package_user_limit_old = ERPPackage::find()->where(['package_id' => $package_id])->one()->user_limit;
        if ($package_user_limit_old > $current_user_limit) {
          if (strtoupper($_COOKIE['companyLang']) == 'AR') {
            $message = 'لخفض مستوى الحزمة يرجى الاتصال على support@erphorizon.com';
          } else {
            $message = 'For Downgrade the package please contact on support@erphorizon.com';
          }
          $json['message'] = $message;
        } else {
          if ($active_user_count > $current_user_limit) {
            if (strtoupper($_COOKIE['companyLang']) == 'AR') {
              $message = 'المستخدم النشط الحالي أكثر من المستخدمين في حزمة مختارة!';
            } else {
              $message = 'Existing active user are more than users in selected package!';
            }
            $json['message'] = $message;


          } else {
            $transaction = Yii::$app->db->beginTransaction();
            $user_config = UserConfig::find()->where(['active_status' => 1])->one();
            $user_config->user_limit = $current_user_limit;
            $flag = $user_config->save();
            if ($flag) {
              $packageModel->user_id = $erp_user->id;
              $packageModel->package_changer = Yii::$app->user->identity->id;
              $packageModel->date = date('Y-m-d');
              $packageModel->time = date('h:i:s');
              $packageModel->prev_date = $user_config->end_date;
              $flag = $packageModel->save();
            }

            if ($flag) {
              $erpUserConfg = ERPUserConfig::find()->where(['user_config_id' => $ERPUserConfig->user_config_id])->one();
              $erpUserConfg->user_limit = $current_user_limit;
              $erpUserConfg->package_id = $packageModel->new_package_id;
              $flag = $erpUserConfg->save();
            }
            // $packageModel->next_date=;
            //   print_r($erpUserConfg);die;

            $ERPUserConfig = ERPUserConfig::find()->joinwith(['companyDetails', 'packageDetails'])->where(['company.user_id' => $erp_user->id])->one();
            if ($flag && ($this->sendEmail('changePackage', $ERPUserConfig))) {
              $transaction->commit();
              if (strtoupper($_COOKIE['companyLang']) == 'AR') {
                $message = 'المستخدم النشط الحالي أكثر من المستخدمين في حزمة مختارة!';
              } else {
                $message = 'Package Succesfully updated!';
              }
              $json['message'] = $message;
            } else {
              $transaction->rollBack();
            }
          }
        }
        return $json;
        // return json_encode($json);
      }
      return $this->renderAjax('change_package_ar', [
        'model' => $packageModel,
        'package_id' => $package_id,
        'company_country' => $country_id,
      ]);
    } else {
      $json = array();
      $packageModel = new PackageHistory();
      $company_country = Company::find()->select(['COUNTRY_CODE'])->one()->COUNTRY_CODE;
      $country_id = ERPCountry::find()->select(['country_id'])->where(['country_code' => $company_country])->createCommand()->queryOne()['country_id'];
      // $user=User::find()->orderBy(['id'=>SORT_ASC])->one();
      $dname = Yii::$app->getDb();
      $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
      //  $erp_user=ERPUser::find()->where(['email'=>$user->email])->one();
      $erp_user = ERPUser::find()->where(['db_name' => $dbname])->one();
      $ERPUserConfig = ERPUserConfig::find()->joinwith(['companyDetails'])->where(['company.user_id' => $erp_user->id])->one();
      $package_id = $ERPUserConfig->package_id;
      $user_limit = $ERPUserConfig->user_limit;
      // echo "<pre>";print_r($package_id);die;
      //    $package_id=Transactions::find()->where(['user_id'=>$erp_user->id])->orderby(['id'=>SORT_DESC])->one()->package;


      if ($packageModel->load(Yii::$app->request->post())) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $active_user_count = User::find()->select(['count(id) as act_user'])->where(['status' => 10])->asArray()->one()['act_user'];
        $current_user_limit = Package::find()->where(['package_id' => $packageModel->new_package_id])->one()->user_limit;
        //echo "<pre>"; print_r($active_user_count);die;
        $package_user_limit_old = ERPPackage::find()->where(['package_id' => $package_id])->one()->user_limit;
        if ($package_user_limit_old > $current_user_limit) {
          if (strtoupper($_COOKIE['companyLang']) == 'AR') {
            $message = 'لخفض مستوى الحزمة يرجى الاتصال على support@erphorizon.com';
          } else {
            $message = 'For Downgrade the package please contact on support@erphorizon.com';
          }
          $json['message'] = $message;
        } else {
          if ($active_user_count > $current_user_limit) {
            if (strtoupper($_COOKIE['companyLang']) == 'AR') {
              $message = 'المستخدم النشط الحالي أكثر من المستخدمين في حزمة مختارة!';
            } else {
              $message = 'Existing active user are more than users in selected package!';
            }
            $json['message'] = $message;

          } else {
            $transaction = Yii::$app->db->beginTransaction();
            $user_config = UserConfig::find()->where(['active_status' => 1])->one();
            $user_config->user_limit = $current_user_limit;
            $flag = $user_config->save();
            if ($flag) {
              $packageModel->user_id = $erp_user->id;
              $packageModel->package_changer = Yii::$app->user->identity->id;
              $packageModel->date = date('Y-m-d');
              $packageModel->time = date('h:i:s');
              $packageModel->prev_date = $user_config->end_date;
              $flag = $packageModel->save();
            }

            if ($flag) {
              $erpUserConfg = ERPUserConfig::find()->where(['user_config_id' => $ERPUserConfig->user_config_id])->one();
              $erpUserConfg->user_limit = $current_user_limit;
              $erpUserConfg->package_id = $packageModel->new_package_id;
              $flag = $erpUserConfg->save();
            }
            // $packageModel->next_date=;
            //   print_r($erpUserConfg);die;

            $ERPUserConfig = ERPUserConfig::find()->joinwith(['companyDetails', 'packageDetails'])->where(['company.user_id' => $erp_user->id])->one();
            if ($flag && ($this->sendEmail('changePackage', $ERPUserConfig))) {
              $transaction->commit();
              if (strtoupper($_COOKIE['companyLang']) == 'AR') {
                $message = 'المستخدم النشط الحالي أكثر من المستخدمين في حزمة مختارة!';
              } else {
                $message = 'Package Succesfully updated!';
              }
              $json['message'] = $message;
            } else {
              $transaction->rollBack();
            }
          }
        }
        return $json;
        // return json_encode($json);
      }
      return $this->renderAjax('change_package', [
        'model' => $packageModel,
        'package_id' => $package_id,
        'company_country' => $country_id,
      ]);
    }
  }

  public function sendEmail($mail_type, $data = array())
  {
    /* @var $user User */
    $user = User::findOne([
      'status' => 10,
      'id' => Yii::$app->user->identity->id,
    ]);

    if (!$user) {
      return false;
    }

    $dname = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
    $company_details = ERPCompany::find()->where(['database_name' => $dbname])->one();

    $sendGrid = Yii::$app->sendGrid;
    if ($data == null) {
      $subject = "Deactive Subscription";
    } else {
      $subject = "Change Package";
    }
    if ($mail_type == "reactiveSubsription") {
      $subject = "Reactive Subscription";
    }
    $message = $sendGrid->compose($mail_type, ['user' => $user, 'data' => $data, 'company_details' => $company_details]);
    return ($message->setFrom('noreply@erphorizon.com')
      ->setTo($user->email)
      ->setTo('info@erphorizon.com')
      ->setSubject($subject)
      ->send($sendGrid));
    // var_dump(Yii::$app->mailer->compose()
    //             ->setFrom('noreply@erphorizon.com')
    //             ->setTo('razanaiyar@gmail.com')
    //             ->setSubject('Password reset for ')
    //             ->setTextBody("Useless body")
    //             ->send());
    // return Yii::$app->mailer->compose(
    //         ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
    //         ['user' => $user]
    //     )
    //     ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
    //     ->setTo($this->email)
    //     ->setSubject('Password reset for ' . Yii::$app->name)
    //     ->send();
  }

  /**
   * Displays a single User model.
   * @param integer $id
   * @return mixed
   */
  public function actionView()
  {

    $lang = strtoupper($_COOKIE['companyLang']);
    //  $user=User::find()->orderBy(['id'=>SORT_ASC])->one();
    $dname = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
    $erp_company = ERPCompany::find()->where(['database_name' => $dbname])->one();
    //print_r( $erp_company);die;
    $transaction = ERPUserConfig::find()->joinwith(['packageDetails', 'companyDetails'])->where(['company.company_id' => $erp_company->company_id])->one();
    // echo "<pre>";print_r($erp_user);die;
    // $erp_company=ERPCompany::find()->where(['user_id'=>$erp_user->id])->one();

    $user_config = ERPUserConfig::find()->where(['company_id' => $erp_company->company_id])->one();
    return $this->renderAjax('view', [
      'transaction' => $transaction,
      'user_config' => $user_config,
      'erp_company' => $erp_company,
      'company_id' => $erp_company->company_id,

    ]);
  }

  /**
   * Creates a new User model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {

    $model = new User();
    if ($model->load(Yii::$app->request->post()) && $model->save()) {

      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
        'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing User model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $email = $model->email;

    $dname = Yii::$app->getDb();
    $dbname = $this->getDsnAttribute('dbname', $dname->dsn);
    $current_user = Yii::$app->user->identity->id;

    if (!Yii::$app->user->can("view_user") && $current_user != $model->id) {
      return array('errors' => array("You are not allow to perform this action"));
    }

    $erp_oth_user = ErpUsers::find()->where(['user_email' => $email, 'db_name' => $dbname])->one();
    $acive_inactive = User::find()->select(['status'])->where(['id' => $id])->one();

    $date_format_arr_php = array('d-m-Y' => 'd-m-Y', 'm/d/Y' => 'm/d/Y');
    $date_format_js_arr = array('d-m-Y' => 'dd-mm-yyyy', 'm/d/Y' => 'mm/dd/yyyy');

    //$erp_user=ERPUser::find()->where(['email'=>$email,'db_name'=>$dbname])->one();

    if ($erp_oth_user == null) {
      $erp_oth_user = new ErpUsers();
      $erp_oth_user->user_email = $model->email;
    }
    /*else{
      $erp_oth_user= ErpUsers::findOne($erp_oth_user->id);
    }*/

    /*if($erp_user==null){
      $erp_user=new ERPUser();
      $erp_user->email=$model->email;
    }*/

    if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {

      Yii::$app->response->format = Response::FORMAT_JSON;

      if (!Yii::$app->user->can("create_user") && $current_user != $model->id) {
        return array('errors' => array("You are not allow to perform this action"));
      }

      $transaction = Yii::$app->db->beginTransaction();
      // $erp_user->load(Yii::$app->request->post());
      $erp_oth_user->load(Yii::$app->request->post());

      // $model->date_format_pp = $_COOKIE['dateFormat'];
      // $model->date_format_js = $_COOKIE['dateFormat_js'];
      $model->status = ($model->status === 'on') ? 0 : 10;

      // if($model->status==10){
      $details = User::find()->select('count(id) as count')->where(['role' => 'admin', 'status' => 10])->createCommand()->queryOne();

      if ($model->status == 0 && $details['count'] < 2 && $model->role == 'admin') {
        Yii::$app->getSession()->setFlash('warning', ['type' => 'warning', 'duration' => 3000, 'icon' => 'fa fa-users', 'message' => 'ATLEAST_ONE_SHOULD_ACTIVE', 'title' => 'error', 'positonY' => 'top', 'positonX' => 'right']);
        return false;
        //  Yii::$app->getSession()->setFlash('error',"Atleast one admin should be active.");
      }

      $config = UserConfig::find()->select(['user_limit'])->where(['active_status' => 1])->one();
      $count_active = User::find()->select('count(id) as count')->where(['status' => 10])->andWhere(['<>', 'id', $model->id])->createCommand()->queryOne()['count'];
      $count_active = ($model->status == 10) ? $count_active + 1 : $count_active;
      $check_status = $config->user_limit < $count_active;

      if (($model->status == 10) && ($check_status)) {
        Yii::$app->getSession()->setFlash('warning', ['type' => 'warning', 'duration' => 3000, 'icon' => 'fa fa-users', 'message' => 'CROSSED_LIMIT', 'title' => 'error', 'positonY' => 'top', 'positonX' => 'right']);
        return false;
        // Yii::$app->getSession()->setFlash();
      }
      // }
      $result = ActiveForm::validate($model);

      $result1 = array();
      //$result2=array();

      if ($result == null) {
        $result1 = ActiveForm::validate($erp_oth_user);
      }
      // if($result==null){
      // $result2=ActiveForm::validate($erp_oth_user);
      //    }

      $final_result = array_merge($result, $result1);

      if ($result != null) {
        return array('errors' => $result);
      } else {
        $model->otp_status = ($email != $model->email) ? 0 : $model->otp_status;

        /*date format save*/
        $model['date_format_pp'] = $model['DATE_FORMAT'];
        $model['date_format_js'] = $date_format_js_arr[$model['DATE_FORMAT']];

        $flag = $model->save();
        $dname = Yii::$app->getDb();
        $dbname = $this->getDsnAttribute('dbname', $dname->dsn);

        if ($email != $model->email) {
          $erp_user = ErpUsers::find()->where(['user_email' => $email, 'db_name' => $dbname])->one();

          if ($erp_user != null) {
            $erp_user->user_email = $model->email;
            if (!$flag = $erp_user->save()) {
              return array('flag' => false, 'errors' => $erp_user->errors);
            }
          }
          // $erp_oth_user=ERPOtherUsers::find()->where(['user_email'=>$email,'db_name'=>$dbname])->one();
          // if(!isset($flag) && $erp_oth_user!=null){
          // $erp_oth_user->user_email=$model->email;
          // $flag=$erp_oth_user->save();
          // }
        }

        if ($flag) {
          $pathdir = "user_log/";
          if (!is_dir($pathdir)) {
            \yii\helpers\FileHelper::createDirectory($pathdir, $mode = 0777, $recursive = true);
          }

          $filename = $pathdir . '/' . $model['id'] . ".txt";
          if (file_exists($filename)) {
            $userFile = fopen($filename, "a");
          } else {
            $userFile = fopen($filename, "w");
          }

          $txt = Date('d-m-Y') . '  ' . date('h:i A') . '     ' . $email . ' -> ' . $model['email'] . '  By ' . $model['username'] . ' (#' . $model['id'] . ')';
          fwrite($userFile, $txt . "\n");
          fclose($userFile);
        }

        if ($flag) {
          $transaction->commit();
          Yii::$app->getSession()->setFlash('success', ['type' => 'success', 'duration' => 3000, 'icon' => 'fa fa-users', 'message' => 'User Successfully Updated', 'title' => 'WELL_DONE', 'positonY' => 'top', 'positonX' => 'right']);
          return true;
        } else {
          $transaction->rollBack();
          Yii::$app->getSession()->setFlash('warning', ['type' => 'warning', 'duration' => 3000, 'icon' => 'fa fa-users', 'message' => 'SOMETHING_WENT_WRONG', 'title' => 'error', 'positonY' => 'top', 'positonX' => 'right']);
        }
      }
    } else {
      return $this->renderAjax('update', [
        'model' => $model,

        'acive_inactive' => $acive_inactive,
        // 'erp_oth_user' => $erp_oth_user,
        // 'erp_user' => $erp_user,
        'date_format_arr_php' => $date_format_arr_php,
      ]);
    }
  }

  private function getDsnAttribute($name, $dsn)
  {
    if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
      return $match[1];
    } else {
      return null;
    }
  }

  /**
   * Deletes an existing User model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id, $checked)
  {

    // $this->findModel($id)->delete();

    $model = $this->findModel($id);

    $details = User::find()->select('count(id) as count')->where(['role' => 'super_admin', 'status' => 10])->createCommand()->queryOne();
    // echo $model->status;die;

    if ($model->status == 10 && $details['count'] < 2 && $model->role == 'super_admin') {

      Yii::$app->getSession()->setFlash('warning', [
        'type' => 'warning',
        'duration' => 3000,
        'icon' => 'fa fa-users',
        'message' => 'ATLEAST_ONE_SHOULD_ACTIVE',
        'title' => 'error',
        'positonY' => 'top',
        'positonX' => 'right'
      ]);
      //  Yii::$app->getSession()->setFlash('error',"Atleast one admin should be active.");


    } else {

      $model->status = ($model->status == 10) ? 0 : 10;
      $config = UserConfig::find()->select(['user_limit'])->where(['active_status' => 1])->one();
      $count_active = User::find()->select('count(id) as count')->where(['status' => 10])->createCommand()->queryOne()['count'];
      // echo 'config->user_limit - '.$config->user_limit.'---'.'count_active - '.$count_active;die;
      $check_status = $config->user_limit > $count_active;
      if (($model->status == 10) && ($check_status == '')) {

        Yii::$app->getSession()->setFlash('warning', [
          'type' => 'warning',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'CROSSED_LIMIT',
          'title' => 'error',
          'positonY' => 'top',
          'positonX' => 'right'
        ]);
        // Yii::$app->getSession()->setFlash();


      } else {
        //$flag=$model->save();
        if (!$flag = $model->save()) {
          Yii::$app->getSession()->setFlash('warning', [
            'type' => 'warning',
            'duration' => 3000,
            'icon' => 'fa fa-users',
            'message' => 'SOMETHING_WENT_WRONG',
            'title' => 'error',
            'positonY' => 'top',
            'positonX' => 'right'
          ]);
          //
        } else {
          // echo $checked;die;
          // print_r($model);die;
          if ($checked) {
            $message = 'SUCCESS_INACTIVE';
          } else {
            $message = 'SUCCESS_ACTIVE';
          }
          Yii::$app->getSession()->setFlash('success', [
            'type' => 'success',
            'duration' => 3000,
            'icon' => 'fa fa-users',
            'message' => $message,
            'title' => 'error',
            'positonY' => 'top',
            'positonX' => 'right'
          ]);
        }
      }

    }


    return true;
  }

  public function actionChangeStatus()
  {
    $transaction = Yii::$app->db->beginTransaction();
    $id = $_POST['id'];
    $checked_status = $_POST['checked_status'];
    $model = $this->findModel($id);
    $flag = 0;

    if ($checked_status == 'true') {
      if (AuthAssignment::findOne(['user_id' => $id]) != null) {
        $flag = AuthAssignment::deleteAll(['user_id' => $id]);
      } else {
        $flag = 1;
      }

      $model_auth = new AuthAssignment();
      $model_auth->item_name = 'admin';
      $model_auth->user_id = $id;
      if ($flag) {
        $flag = $model_auth->save();
      }

      if ($flag) {
        $model->role = 'admin';
        $flag = $model->save();
      }
    } else {

      $details = User::find()->select('count(id) as count')->where(['role' => 'admin', 'status' => 10])->createCommand()->queryOne();
      if (($details['count'] < 2) && $model->status == 10) {
        if (strtoupper($_COOKIE['companyLang']) == 'AR') {
          Yii::$app->getSession()->setFlash('error', "على الأقل واحد المشرف يجب أن تكون نشطة.");
        } else {
          Yii::$app->getSession()->setFlash('error', "Atleast one admin should be active.");
        }

      } else {
        if (AuthAssignment::findOne(['user_id' => $id]) != null) {
          $flag = AuthAssignment::deleteAll(['user_id' => $id]);
        } else {
          $flag = 1;
        }
        if ($flag) {
          $model->role = 'Customized';
          $flag = $model->save();
        }

      }

    }
    if ($flag) {
      $transaction->commit();
      if (strtoupper($_COOKIE['companyLang']) == 'AR') {
        Yii::$app->getSession()->setFlash('success', 'الأدوار بنجاح تحديث');
      } else {
        Yii::$app->getSession()->setFlash('success', 'Roles Succesfully Update!');
      }

    } else {
      $transaction->rollBack();

    }
    return true;
    //return $this->redirect(['index']);
  }

  /**
   * Finds the User model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return User the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}
