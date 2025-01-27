<?php

namespace backend\controllers;

use Yii;
use backend\models\PaymentMaster;
use backend\models\CustomerMaster;
use backend\models\PaymentMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * PaymentController implements the CRUD actions for PaymentMaster model.
 */
class PaymentController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'payment-report', 'payment-search'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * Lists all PaymentMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $date = (isset($_GET['month']) && isset($_GET['year'])) ? $_GET['month'] . '-' . $_GET['year'] : date('m-Y');
        $searchModel = new PaymentMasterSearch();
        $searchModel->month_year_filter = $date;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $date=date('m-Y');
        $payment_summarys = PaymentMaster::find()->select(['sum(amount) as total', 'mode_of_payment'])->where('DATE_FORMAT(date, "%m-%Y") = "' . $date . '"')->groupby(['mode_of_payment'])->createCommand()->queryAll();
        //print_r($payment_summarys);die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'payment_summarys' => $payment_summarys,
        ]);
    }

    /**
     * Displays a single PaymentMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPaymentSearch()
    {

        $model = new PaymentMasterSearch();
        $customer_master = (ArrayHelper::map(CustomerMaster::find()->all(), 'id', 'name'));

        return $this->render('payment_search', [
            'model' => $model,
            'array_payment_status' => ['Advance' => 'Advance', 'Per-payment' => 'Per-payment', 'Final-Payment' => 'Final-Payment', 'Return-Deposit' => 'Return-Deposit', 'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges', 'Return-Payment' => 'Return-Payment'],
            'customer_master' => $customer_master,
            'array_payment_mode' => ['Cash' => 'Cash', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other', 'Credit' => 'Credit', 'Deposit' => 'Deposit'],
        ]);
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
            return $this->redirect(['payment/payment-search']);
        }
        $view_name = 'payment_report';
        if (isset(Yii::$app->request->post()['export_type'])) { // For Full Export
            $searchModel->attributes = Yii::$app->request->post();
            Yii::$app->request->queryParams = array('PaymentMasterSearch' => $searchModel);
        }
        if (isset(Yii::$app->request->post()['PaymentMasterSearch'])) {
            if (Yii::$app->request->post()['PaymentMasterSearch']['view_level'] == 'DETAIL') {
                $dataProvider = $searchModel->searchReport(Yii::$app->request->post());

            } elseif (Yii::$app->request->post()['PaymentMasterSearch']['view_level'] == 'OVERVIEW') {
               $view_name = 'payment_overview';
                $dataProvider = $searchModel->searchOverview(Yii::$app->request->post());
            } else {
                $view_name = 'cash_flow_report';
                $dataProvider = $searchModel->searchSummary(Yii::$app->request->post());
            }
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
                $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

            }elseif ($view_level == 'OVERVIEW') {
               $view_name = 'payment_overview';
                $dataProvider = $searchModel->searchOverview(Yii::$app->request->post());
            } else {
                $view_name = 'cash_flow_report';
                $dataProvider = $searchModel->searchSummary(Yii::$app->request->queryParams);
            }


        }


        return $this->render($view_name, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'payment_summarys' => $payment_summarys,
        ]);

    }

    /**
     * Creates a new PaymentMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PaymentMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payment_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PaymentMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payment_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PaymentMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PaymentMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaymentMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaymentMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
