<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pickup Items';

?>
<style type="text/css">
    td,th{
    font-size: 15px; 
}
</style>
<div class="booking-item-index">

  <h1></h1>

    <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Sales</a></li>
                            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
                        </ol>
                    </div>
              
                </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
          'tableOptions' => ['class' => 'display nowrap table table-hover color-bordered-table muted-bordered-table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             [
             // 'attribute' => 'images',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Image',
                /* 'format' => 'image',
             'value'=>function($data) { return $data->imageurl; },*/
             'format' => 'html',
              'value' => function($data) { return '<div class="image-gallery"><a class="image-popup-vertical-fit" href="'
                .$data->item->imageurl.'"> '
                .Html::img($data->item->imageurl, ['width'=>'100','height'=>'80']).'</a> </div>'; },
              
            ],
           // 'booking.customer.name',
             [ 
              'attribute'=>'booking.customer.name',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:15%'],
             'value' => function($model, $key, $index, $grid){
                 return Html::a( $model->booking->customer->name, ['booking/update','id' => $model->booking_id], ['title' => 'View','class'=>'link_cust']);
                },
            ],

            [
        'attribute' => 'pickup_date',
        'enableSorting' => false,

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
            //'item_no',
            //'pickup_date',
            //'item.name',
           // 'description',
            [
        'attribute' => 'description',
        'enableSorting' => false
         ],
           // 'net_value',
            [
        'attribute' => 'net_value',
        'enableSorting' => false
         ],
           [
             'attribute' => 'Measurment',
             'filter' => false,
             'format' => 'raw',
             'value' => function ($model) {
                    $header = $model->booking;
                    $remark = ($header->remark != null || $header->remark != "") ? "Remark: ".$header->remark: " ";
                    if($header->chest == null || $header->chest == "0.00" ){
                      return $remark;
                    }
                    return "C: ".$header->chest.", W: ".$header->waist.", H: ".$header->hip." <br> ".$remark;
              },
           ],
            [
        'attribute' => 'item_status',
        'enableSorting' => false
         ],

            'note:ntext',
            //'deposite_status',
            //'payment_status',
        ],
    ]); ?>

</div>
</div>
</div>
</div>
</div>
<script src="kai-admin-assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="kai-admin-assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js"></script>

<script type="text/javascript">

  $(document).ready(function ($) {
    $('.image-gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      removalDelay: 300,
      gallery: {
        enabled: false,
      },
      mainClass: 'mfp-with-zoom',
      zoom: {
        enabled: true,
        duration: 300,
        easing: 'ease-in-out',
        opener: function (openerElement) {
          return openerElement.is('img') ? openerElement : openerElement.find('img');
        }
      }
    });
  });

</script>