<?php

namespace backend\controllers;

use backend\models\CustomerMaster;
use backend\models\PaymentMasterSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class PaymentReportController extends \yii\web\Controller
{
  public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view',  'payment-report', 'payment-search'],
                        'allow' => true,
                        'roles' => ['report'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
      $model = new PaymentMasterSearch();
    $customer_master = (ArrayHelper::map(CustomerMaster::find()->all(), 'id', 'name'));

        return $this->render('index',['model' => $model, 'customer_master' => $customer_master, ]);
    }
    public function actionPaymentReport()
    {
        $searchModel = new PaymentMasterSearch();
        // $searchModel->month_year_filter=$date;
        //$searchModel->pagination= false;
        // $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        //$model = new BillingItem();

        //echo '<pre>';print_r(Yii::$app->request->post());die;
        if (!isset(Yii::$app->request->queryParams['PaymentMasterSearch']) && !isset(Yii::$app->request->post()['PaymentMasterSearch']) && !isset(Yii::$app->request->queryParams['sort']) && !isset(Yii::$app->request->post()['export_type'])) {
            //&& !isset(Yii::$app->request->post()['export_type']) && !isset($_GET['no_page'])
            return $this->redirect(['payment-report/index']);
        }
        $view_name = 'payment_report';
        if (isset(Yii::$app->request->post()['export_type'])) { // For Full Export
            $searchModel->attributes = Yii::$app->request->post();
            Yii::$app->request->queryParams = array('PaymentMasterSearch' => $searchModel);
        }
        if (isset(Yii::$app->request->post()['PaymentMasterSearch'])) {
            if (Yii::$app->request->post()['PaymentMasterSearch']['view_level'] == 'DETAIL') {
                $dataProvider = $searchModel->searchTransaction(Yii::$app->request->post());

            } /*elseif (Yii::$app->request->post()['PaymentMasterSearch']['view_level'] == 'OVERVIEW') {
               $view_name = 'payment_overview';
                $dataProvider = $searchModel->searchOverview(Yii::$app->request->post());
            } else {
                $view_name = 'cash_flow_report';
                $dataProvider = $searchModel->searchSummary(Yii::$app->request->post());
            }*/
            Yii::$app->request->queryParams = Yii::$app->request->post();
        } else {
            $view_level = 'DETAIL';
            if(isset(Yii::$app->request->post()['PaymentMasterSearch']['view_level'])){
                $view_level = Yii::$app->request->post()['PaymentMasterSearch']['view_level'];
            }elseif (Yii::$app->request->post()['view_level']){
                $view_level = Yii::$app->request->post()['view_level'];
            }
           // $view_level = isset(Yii::$app->request->post()['PaymentMasterSearch']['view_level']) ? Yii::$app->request->post()['PaymentMasterSearch']['view_level'] : 'DETAIL';
            if ($view_level == 'DETAIL') {
                $dataProvider = $searchModel->searchTransaction(Yii::$app->request->queryParams);

            }/*elseif ($view_level == 'OVERVIEW') {
               $view_name = 'payment_overview';
                $dataProvider = $searchModel->searchOverview(Yii::$app->request->post());
            } else {
                $view_name = 'cash_flow_report';
                $dataProvider = $searchModel->searchSummary(Yii::$app->request->queryParams);
            }*/


        }


        return $this->render($view_name, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'payment_summarys' => $payment_summarys,
        ]);

    }

}
