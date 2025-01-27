<?php

namespace backend\controllers;

use Yii;
use backend\models\BookingItem;
use backend\models\BookingItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\BookingHeader;
use backend\models\CategoryMaster;
use backend\models\TypeMaster;
use yii\helpers\ArrayHelper;
/**
 * BookingItemController implements the CRUD actions for BookingItem model.
 */
class BookingItemController extends Controller
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
                        'actions' => ['logout', 'index','view','create','update','delete','index-return','sales-item'],
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
     * Lists all BookingItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookingItemSearch();
        $searchModel->item_status='Booked';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
   public function actionIndexReturn()
    {
        $searchModel = new BookingItemSearch();
        $searchModel->item_status='Picked';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
        public function actionSalesItem()
    {
       // $date=date('m-Y');
         $date=(isset($_GET['month'])&&isset($_GET['year']))?$_GET['month'].'-'.$_GET['year']:date('m-Y');
        $searchModel = new BookingItemSearch();
        $searchModel->date=$date;
        $type_master = ArrayHelper::map(TypeMaster::find()->all(),'id','name');
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
         $booking_id=BookingHeader::find()->select('booking_id')->where(['order_status'=>array('Open','Closed','Cancelled')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "'. $date.'"');
         $booking_item_summmary=BookingItem::find()->select(['sum(amount) as total_rent','sum(booking_item.deposit_amount) total_deposite_amount','sum(net_value) total_net_value','category_id'])->where(['booking_id'=>$booking_id])->joinWith('item')->groupBy('category_id')->createCommand()->queryAll();
       // $searchModel->booking_id=$booking_id;
         //print_r($booking_item_summmary);die;
        $dataProvider = $searchModel->searchItem(Yii::$app->request->queryParams);
 $dataProvider->pagination=false;
        return $this->render('sales', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'booking_item_summmary'=>$booking_item_summmary,
            'title'=>"Sales item",
            'type_master'=>$type_master,
            'model_category'=>$model_category
        ]);
    }
    /**
     * Displays a single BookingItem model.
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

    /**
     * Creates a new BookingItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BookingItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->item_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookingItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->item_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookingItem model.
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
     * Finds the BookingItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookingItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookingItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
