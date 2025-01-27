<?php

namespace backend\controllers;

use backend\models\CategoryMaster;
use Yii;
use backend\models\TypeMaster;
use backend\models\ItemMaster;
use backend\models\TypeMasterSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * TypeController implements the CRUD actions for TypeMaster model.
 */
class TypeController extends Controller
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
                        'actions' => ['logout', 'index','view','create','update','delete'],
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
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * Lists all TypeMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TypeMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TypeMaster model.
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
     * Creates a new TypeMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TypeMaster();
        $category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
        $status_array= array(0=>'Yes',1=>'No');
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
           $result= ActiveForm::validate($model);
             if($result!=null){
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors'=>$result);
           }else{
            $model->save();
            return $this->redirect(['index']);
        }
        }

        return $this->renderPartial('create', [
            'model' => $model,
            'category'=>$category,
            'status_array'=>$status_array,
        ]);
    }

    /**
     * Updates an existing TypeMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $item_model=ItemMaster::find()->where(['type_id'=>$id])->all();
        if($item_model==null){
          $category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
        }else{
            $category = ArrayHelper::map(CategoryMaster::find()->where(['id'=>$model->category_id])->all(),'id','name');
        }
           $status_array= array(0=>'Yes',1=>'No');
         if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
           $result= ActiveForm::validate($model);
             if($result!=null){
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors'=>$result);
           }else{
            $model->save();
            return $this->redirect(['index']);
        }
        }

        return $this->renderPartial('update', [
            'model' => $model,
             'category'=>$category,
             'status_array'=>$status_array,
        ]);
    }

    /**
     * Deletes an existing TypeMaster model.
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
     * Finds the TypeMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TypeMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TypeMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
