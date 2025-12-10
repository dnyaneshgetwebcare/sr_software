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
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [ 'index',  'payment-report','payment-search', 'latest-transaction', 'reconcile-bank-transaction'],
                        'allow' => true,
                        'roles' => ['limited_report'],
                    ],
                    [
                        'actions' => [ 'index',  'payment-report', 'payment-search', 'latest-transaction', 'reconcile-bank-transaction'],
                        'allow' => true,
                        'roles' => ['reports'],
                    ],
                    [
                        'actions' => [  'latest-transaction'],
                        'allow' => true,
                        'roles' => ['call_center'],
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
     * Lists latest payment transactions (last 5 days).
     * @return mixed
     */
    public function actionLatestTransaction()
    {
        // Calculate date range for last 5 days
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-5 days'));
        $user = Yii::$app->user->identity;
        $is_admin = ($user->user_type == "admin") ? true : false;
        $searchModel = new PaymentMasterSearch();
        // Set date range in query params to ensure it's used
        $queryParams = Yii::$app->request->queryParams;
        if (!isset($queryParams['PaymentMasterSearch'])) {
            $queryParams['PaymentMasterSearch'] = [];
        }
        $queryParams['PaymentMasterSearch']['from_date'] = $startDate;
        $queryParams['PaymentMasterSearch']['to_date'] = $endDate;
        
        $dataProvider = $searchModel->search($queryParams);

        // Get payment summary for last 5 days
        $payment_summarys = PaymentMaster::find()
            ->select(['sum(amount) as total', 'mode_of_payment'])
            ->where(['>=', 'date', $startDate])
            ->andWhere(['<=', 'date', $endDate])
            ->groupBy(['mode_of_payment'])
            ->orderBy('date', SORT_DESC)
            ->createCommand()
            ->queryAll();
        
        return $this->render('latest-transaction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'payment_summarys' => $payment_summarys,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'is_admin' => $is_admin,
        ]);
    }

    /**
     * Lists bank transactions for reconciliation.
     * Filters: payment mode NOT IN (cash, deposit, Carry_Frwd) AND type NOT IN (Return-Deposit, Return-Payment)
     * @return mixed
     */
    public function actionReconcileBankTransaction()
    {
        $searchModel = new PaymentMasterSearch();
        $queryParams = Yii::$app->request->queryParams;
        
        // Set default date to today if not provided
        if (!isset($queryParams['PaymentMasterSearch']['date']) || empty($queryParams['PaymentMasterSearch']['date'])) {
            if (!isset($queryParams['PaymentMasterSearch'])) {
                $queryParams['PaymentMasterSearch'] = [];
            }
            $queryParams['PaymentMasterSearch']['date'] = date('d-m-Y');
        }
        
        $dataProvider = $searchModel->searchReconcileBankTransaction($queryParams);

        return $this->render('reconcile-bank-transaction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
                if(!Yii::$app->user->can('reports')){
                    throw \yii\web\ForbiddenHttpException( 'You are not allowed to perform this action.');
                }
                $dataProvider = $searchModel->searchReport(Yii::$app->request->post());

            } elseif (Yii::$app->request->post()['PaymentMasterSearch']['view_level'] == 'OVERVIEW') {
                if(!Yii::$app->user->can('reports')){
                    throw new \yii\web\ForbiddenHttpException( 'You are not allowed to perform this action.');
                }
               $view_name = 'payment_overview';
                $dataProvider = $searchModel->searchOverview(Yii::$app->request->post());
            } else {
                if( !(Yii::$app->user->can('limited_report')) ){
                    throw new \yii\web\ForbiddenHttpException( 'You are not allowed to perform this action.');
                }

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
                if(!Yii::$app->user->can('reports')){
                    throw new \yii\web\ForbiddenHttpException( 'You are not allowed to perform this action.');
                }
                $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

            }elseif ($view_level == 'OVERVIEW') {
                if(!Yii::$app->user->can('reports')){
                    throw new \yii\web\ForbiddenHttpException( 'You are not allowed to perform this action.');
                }
               $view_name = 'payment_overview';
                $dataProvider = $searchModel->searchOverview(Yii::$app->request->post());
            } else {
                if( !(Yii::$app->user->can('limited_report')) ){
                    throw \yii\web\ForbiddenHttpException( 'You are not allowed to perform this action.');
                }
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
