<?php

use yii\helpers\Html;
use backend\models\BookingHeader;
use yii\grid\GridView;
//use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Booking';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
     
  td,th{
    font-size: 15px; 
}

</style>
<div class="booking-header-index">
<div class="row page-titles">
   
<div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Report</a></li>
                            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
                        </ol>
                    </div>
  </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive m-t-0">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'showFooter' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn','headerOptions' => ['style' => 'width:5%'],],
          [ 'attribute'=>'booking_id',
             'headerOptions' => ['style' => 'width:5%'],
             'header'=>'#'
            ],
            [
              'attribute' => 'item_status',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'item_status',(array('Booked', 'Picked', 'Returned', 'Cancelled')),['class'=>'form-control']),
              //'format' => 'html',
              /*'value' => function ($model, $key, $index, $grid){
                if ($model->item_status=='Booked') {
                  //return $model->GOODS_ISSUE_STATUS;
                  return '<img src="img/icons/close-icon.png" style="height:18px" title="Unpaid">';
                } else {
                  // $age = '<span  style="color:#604c4c;font-size: 11px;background: #DFF0D8"><b>CLOSED</b></span>';
                   return '<img src="img/icons/open-icon.png" style="height:19px" title="Paid">';
                  //return $age;
                } 
              },*/
            ],
           [
              'attribute'=>'description',
              'headerOptions' => ['style' => 'width:10%'],
              'header'=>'Item',
             
            ],
           [
              'attribute'=>'item.name',
              'headerOptions' => ['style' => 'width:10%'],
             'header'=>'Type',
             'filter'=>Html::activeDropDownList($searchModel, 'item_status',($type_master),['class'=>'form-control','prompt'=>'Select Type']),
            ],
            [
              'attribute'=>'category.name',
              'headerOptions' => ['style' => 'width:10%'],
             'header'=>'Category',
             'filter'=>Html::activeDropDownList($searchModel, 'item_status',($model_category),['class'=>'form-control','prompt'=>'Select Category']),
            ],
            [
              'attribute'=>'item.colourCat.name',
              'headerOptions' => ['style' => 'width:10%'],
             'header'=>'Color',
             'filter'=>Html::activeDropDownList($searchModel, 'item_status',($color_model),['class'=>'form-control','prompt'=>'Select Category']),
            ],
            [
              'attribute'=>'pickup_date',
              'headerOptions' => ['style' => 'width:10%'],
              'value'=> function($model, $key, $index, $grid){
                if($model->pickup_date==null){
                  return '-';
                }
                return Yii::$app->formatter->asDate($model->pickup_date,'dd-MM-yyyy');
               },
                    /*'filterType'=>'\kartik\date\DatePicker',
                              'filterWidgetOptions' =>  ['pluginOptions' => [
                                 'todayHighlight'=>true,
                                  'autoclose'=>true,
                                  'format' => 'dd-mm-yyyy'
                                ]
                            ],*/
            ],
            [
              'attribute'=>'return_date',
              'headerOptions' => ['style' => 'width:10%'],
              'value'=> function($model, $key, $index, $grid){
                if($model->return_date==null){
                  return '-';
                }
                return Yii::$app->formatter->asDate($model->return_date,'dd-MM-yyyy');
               },
                    /*'filterType'=>'\kartik\date\DatePicker',
                              'filterWidgetOptions' =>  ['pluginOptions' => [
                                 'todayHighlight'=>true,
                                  'autoclose'=>true,
                                  'format' => 'dd-mm-yyyy'
                                ]
                            ],*/
                            'footer' => "<b>Total</b>",
            ],
            //'pickup_date',
            //'picked_date',
            //'return_date',
            //'returned_date',
             [ 'attribute'=>'net_value',
             'headerOptions' => ['style' => 'width:10%'],
             'format'=>['decimal',0],
             'footer' => BookingHeader::getTotal($dataProvider->models, 'net_value'),
            ],
           
           
           
            
        ],
    ]); ?>


</div>
</div>
</div>
</div>
</div>
</div>