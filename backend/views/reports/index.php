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
              'attribute' => 'payment_status',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'payment_status',(array('Incomplete','Complete')),['class'=>'form-control']),
              'format' => 'html',
              'value' => function ($model, $key, $index, $grid){
                if ($model->payment_status=='0') {
                  //return $model->GOODS_ISSUE_STATUS;
                  return '<img src="img/icons/close-icon.png" style="height:18px" title="Unpaid">';
                } else {
                  // $age = '<span  style="color:#604c4c;font-size: 11px;background: #DFF0D8"><b>CLOSED</b></span>';
                   return '<img src="img/icons/open-icon.png" style="height:19px" title="Paid">';
                  //return $age;
                } 
              },
            ],
            //'booking_id',
            
             [
              'attribute'=>'booking_date',
              'headerOptions' => ['style' => 'width:10%'],
              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model->booking_date,'dd-MM-yyyy');
               },
                    /*'filterType'=>'\kartik\date\DatePicker',
                              'filterWidgetOptions' =>  ['pluginOptions' => [
                                 'todayHighlight'=>true,
                                  'autoclose'=>true,
                                  'format' => 'dd-mm-yyyy'
                                ]
                            ],*/
            ],
           //'booking_date',
            [ 
              'attribute'=>'customer.name',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:20%'],
             'value' => function($model, $key, $index, $grid){
                 return Html::a( $model->customer->name, ['booking/update','id' => $model->booking_id], ['title' => 'View','class'=>'link_cust']);
                },
            ],
            [
              'attribute'=>'pickup_date',
              'headerOptions' => ['style' => 'width:10%'],
              'value'=> function($model, $key, $index, $grid){
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
           
            [ 'attribute'=>'deposite_amount',
             'headerOptions' => ['style' => 'width:10%'],
             'format'=>['decimal',0],
             'header'=>'Deposite Amt',
             'footer' => BookingHeader::getTotal($dataProvider->models, 'deposite_amount'),
            ],
            //'discount',
            //'deposite_applicable',
           // 'deposite_amount',
            //'payment_status',
           
            //'deposite_status',
            //'order_status',
            //'status',
           [ 'attribute'=>'status',
             'headerOptions' => ['style' => 'width:10%'],
            ],
            ['class' => 'yii\grid\ActionColumn','template'=>' {update}{delete}',
            'headerOptions' => ['style' => 'width:10%'],],
        ],
    ]); ?>


</div>
</div>
</div>
</div>
</div>
</div>
