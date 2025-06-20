<?php

namespace backend\controllers;

use backend\models\CategoryMaster;
use backend\models\ItemMaster;
use backend\models\TypeMaster;
use Yii;
use yii\db\Expression;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // CORS Filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost','http://localhost:3000'], // Allow all domains
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'], // Allowed methods
                'Access-Control-Allow-Credentials' => true, // Allow credentials (cookies, auth)
                'Access-Control-Allow-Headers' => ['Authorization', 'Content-Type', 'X-Requested-With'],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionItemList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = isset($_GET['type'])?$_GET['type'] : '';
        $category = isset($_GET['category'])?$_GET['category'] : '';
        $page_limt = isset($_GET['page_limit'])?$_GET['page_limit'] : 20;
        $page_nos = isset($_GET['page_nos'])?$_GET['page_nos'] : 1;
        $occation = isset($_GET['display_cat'])?$_GET['display_cat'] : "";
        $offset = ($page_limt * $page_nos) -$page_limt;
        if($type != ""){
          $type = explode(",",$type);
        }
        $item_master = ItemMaster::find()->select(['item_master.id', 'item_master.name', 'item_master.details',  'type_id', 'type_master.name as type_name', 'item_master.category_id', 'category_master.name as category_name', 'rent_amount', 'colour_cat', 'color_master.name as color_name', 'images', 'size'])
            ->leftJoin('type_master','type_master.id = item_master.type_id')
            ->leftJoin('category_master',
                'item_master.category_id = category_master.id')
            ->leftJoin('color_master', 'colour_cat = color_master.id')
            ->andWhere(['scrab_status' =>
                'No' , 'delete_status' => 0 , 'skip_website' =>
                0]);
        if($occation!=""){
          $item_master->andWhere(new Expression("FIND_IN_SET(:value, display_type)"))
          ->addParams([':value' => $occation]);
        }
        $item_master->andFilterWhere(['item_master.category_id' => $category, 'type_id'=> $type])->limit($page_limt)
            ->offset($offset)->asArray
            ()->all();
        $image_def_path =\Yii::$app->request->BaseUrl.'https://app.thesoyara.com/uploads/';
        $no_image_path = \Yii::$app->request->BaseUrl.'https://app.thesoyara.com/img/no-image.jpg';

        return array("item_master" => $item_master,'no_image_path' => $no_image_path, 'image_def_path' =>
            $image_def_path );

    }
    public function actionTypeList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = isset($_GET['type'])?$_GET['type'] : '';
        $category_id = isset($_GET['category_id'])?$_GET['category_id'] : '';

        $type_master = TypeMaster::find()->andFilterWhere(['id' => $type, 'category_id' =>$category_id])->andWhere(['dispaly_main_site'
        =>
            '1' ]) ->asArray()->all();
        return $type_master;

    }

    public function actionCategoryList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $category_id = isset($_GET['category_id'])?$_GET['category_id'] : '';

        $category_master = CategoryMaster::find()->andFilterWhere(['id' => $category_id])->asArray()->all();
        return $category_master;

    }
    public function actionImageView($filename)
    {
        // Secure folder where images are stored
        $filePath = Yii::getAlias('@web/uploads/2/') . $filename;
//echo $filePath;die;
        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException("Image not found.");
        }

        // Optional: Check if the user is authenticated
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException("You are not authorized to view this image.");
        }

        // Serve the image securely
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', mime_content_type($filePath));
        return file_get_contents($filePath);
    }
    public function actionGetCategory()
    {

    }
}
