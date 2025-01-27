<?php
namespace backend\controllers;

use backend\models\BookingSummary;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\BookingHeader;
use backend\models\CustomerMaster;
use backend\models\PaymentMaster;
use yii\helpers\ArrayHelper;
use backend\models\ExpenseHeader;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
         $model_delivary=BookingHeader::find()->where(['order_status'=>'Open','status'=>'Booked'])->andWhere('pickup_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)')->orderBy(['pickup_date'=>SORT_ASC])->all();
        $model_returns=BookingHeader::find()->where(['order_status'=>'Open','status'=>'Picked'])->andWhere('return_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)')->orderBy(['return_date'=>SORT_ASC])->all();
        $dep_pending=BookingHeader::find()->where(['order_status'=>'Open','status'=>'Returned','payment_status'=>1])->all();
        $booking_this_month=BookingHeader::find()->select(['count(*) as numb_booking','sum(rent_amount) as total'])->where('MONTH(pickup_date)=MONTH(CURRENT_DATE())')->andWhere(['order_status'=>array('Open','Cancelled','Closed')])->asArray()->one();
        $payment_cash=PaymentMaster::find()->select(['sum(amount) total'])->where(['mode_of_payment'=>'Cash'])->andWhere('MONTH(date)=MONTH(CURRENT_DATE())')->andWhere(['Not IN','type',array('Deposit','Return-Deposit')])->asArray()->one();
         $deposite_amt=PaymentMaster::find()->select(['sum(amount) total'])->where('MONTH(date)=MONTH(CURRENT_DATE())')->andWhere(['type'=>'Return-Deposit'])->asArray()->one();
         $expense=ExpenseHeader::find()->select(['sum(expense_amount) total'])->where('MONTH(expense_date)=MONTH(CURRENT_DATE())')->asArray()->one();
        //print_r($booking_this_month);die;
        $sale_monthly_summary=BookingSummary::find()->where(['year'=>date('Y')])->asArray()->all();
        $number_customer=CustomerMaster::find()->select(['count(*) total_cust','MONTH(created_on) month'])->where('YEAR(created_on)=YEAR(CURRENT_DATE())')->andWhere(['status'=>'0'])->groupBy('MONTH(created_on)')->asArray()->all();
        $number_invoice=BookingHeader::find()->select(['count(*) total_inv','MONTH(booking_date) month'])->where('YEAR(booking_date)=YEAR(CURRENT_DATE())')->groupBy('MONTH(booking_date)')->asArray()->all();
        $cust_list=ArrayHelper::map($number_customer,'month','total_cust');
        $invoice_list=ArrayHelper::map($number_invoice,'month','total_inv');
        $graph_summary=ArrayHelper::map($sale_monthly_summary,'month','amount');
        //print_r($cust_list);die;
        //echo $key;
       // print_r($sale_monthly_summary[$key]);die;
        $total_sales=array_fill(0, 12, 0);
        for ($i=0; $i <12 ; $i++) { 
           $total_sales[$i]=(isset($graph_summary[$i]))?$graph_summary[$i]:0;
        }
        $user = Yii::$app->user->identity;
        $is_admin = ($user->user_type == "admin") ? true: false;
        return $this->render('index',
            ['model_delivarys'=>$model_delivary,
                'model_returns'=>$model_returns,
                'booking_this_month'=>$booking_this_month,
                'deposite_amt'=>$deposite_amt,
                'payment_cash'=>$payment_cash,
                'expense'=>$expense,
                'cust_list'=>$cust_list,
                'dep_pending'=>$dep_pending,
                'total_sales'=>$total_sales,
                'invoice_list'=>$invoice_list,
                'is_admin'=>$is_admin,
                'sale_monthly_summary'=>$sale_monthly_summary]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
