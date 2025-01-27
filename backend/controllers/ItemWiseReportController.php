<?php

namespace backend\controllers;

use backend\models\BookingItemSearch;
use backend\models\ItemMasterSearch;
use Yii;


class ItemWiseReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionItemFilter()
    {

        $model = new BookingItemSearch();
        //$customer_master=(ArrayHelper::map(CustomerMaster::find()->all(), 'id', 'name'));

        return $this->render('item_search', [
            'model' => $model,

        ]);
    }

    public function actionItemReport()
    {
        $searchModel = new BookingItemSearch();
        // $searchModel->month_year_filter=$date;
        //$searchModel->pagination= false;
        // $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        //$model = new BillingItem();

        //echo '<pre>';print_r(Yii::$app->request->post());die;
        if (!isset(Yii::$app->request->queryParams['BookingItemSearch']) && !isset(Yii::$app->request->post()['BookingItemSearch']) && !isset(Yii::$app->request->queryParams['sort']) && !isset(Yii::$app->request->post()['export_type'])) {
            //&& !isset(Yii::$app->request->post()['export_type']) && !isset($_GET['no_page'])
            return $this->redirect(['item-wise-report/item-filter']);
        }
        $view_name = 'item_report';
        if (isset(Yii::$app->request->post()['export_type'])) { // For Full Export
            $searchModel->attributes = Yii::$app->request->post();
            Yii::$app->request->queryParams = array('BookingItemSearch' => $searchModel);
        }
        if (isset(Yii::$app->request->post()['BookingItemSearch'])) {
            if (Yii::$app->request->post()['BookingItemSearch']['view_level'] == 'DETAIL') {
                $dataProvider = $searchModel->searchItem(Yii::$app->request->post());

            }elseif(Yii::$app->request->post()['BookingItemSearch']['view_level'] == 'Type_Wise'){
                $view_name = 'item_type_report';
                $dataProvider = $searchModel->searchItemType(Yii::$app->request->post());
            } else {
                $view_name = 'item_cat_report';
                $dataProvider = $searchModel->searchItemCategory(Yii::$app->request->post());
            }
            Yii::$app->request->queryParams = Yii::$app->request->post();
        } else {
            $view_level = isset(Yii::$app->request->post()['BookingItemSearch']['view_level']) ? Yii::$app->request->post()['BookingItemSearch']['view_level'] : 'DETAIL';
            if ($view_level == 'DETAIL') {
                $dataProvider = $searchModel->searchItem(Yii::$app->request->queryParams);

            }elseif($view_level == 'Type_Wise'){
                $view_name = 'item_type_report';
                $dataProvider = $searchModel->searchItemType(Yii::$app->request->queryParams);
            } else {
                $view_name = 'item_cat_report';
                $dataProvider = $searchModel->searchItemCategory(Yii::$app->request->queryParams);
            }


        }
//echo "<pre>";print_r($dataProvider->models); die;

        return $this->render($view_name, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);

    }
}
