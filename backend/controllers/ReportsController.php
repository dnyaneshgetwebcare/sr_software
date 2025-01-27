<?php

namespace backend\controllers;
use Yii;
use backend\models\BookingHeaderSearch;
use backend\models\BookingItemSearch;
use backend\models\ItemMasterSearch;
use backend\models\ItemMaster;
use backend\models\ColorMaster;
use backend\models\TypeMaster;
use backend\models\CategoryMaster;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
class ReportsController extends \yii\web\Controller
{
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
                        'actions' => ['logout', 'index','index-item','index-item-master'],
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

      public function actionIndex()
    {
       
        $searchModel = new BookingHeaderSearch();
  
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
public function actionIndexItem()
    {
       
        $searchModel = new BookingItemSearch();
        
        $type_master = ArrayHelper::map(TypeMaster::find()->all(),'id','name');
        $color_model=ArrayHelper::map(ColorMaster::find()->all(),'id','name');
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type_master'=>$type_master,
            'model_category'=>$model_category,
             'color_model'=>$color_model,
        ]);
    }
    public function actionIndexItemMaster()
    {
       
        $searchModel = new ItemMasterSearch();
    
        $type_master = ArrayHelper::map(TypeMaster::find()->all(),'id','name');
        $color_model=ArrayHelper::map(ColorMaster::find()->all(),'id','name');
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_item_master', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type_master'=>$type_master,
            'model_category'=>$model_category,
             'color_model'=>$color_model,
        ]);
    }
}
