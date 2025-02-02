<?php

use kartik\export\ExportMenu;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
use backend\models\PaymentMaster;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaction';

?>
<style type="text/css">
  td,th{
    font-size: 12px;
}
  .btn-group label {
      color: black !important;
  }
.form-group {
         margin-bottom: 0px;
     }

     .form-control {
         font-size: medium;
         font-weight: 500;
     }
</style>
<div class="payment-master-index">




  <div class="row">
                    <div class="col-12" style="overflow: auto;">
                        <div class="card" style="width: 100%; ">
                            <div class="card-body">

<div class="table-responsive m-t-40">
    <?php
   //echo "<pre>"; echo json_encode($searchModel); print_r($searchModel);die;
    $exportParamData = array();
      $post_data = !empty(Yii::$app->request->queryParams) ? Yii::$app->request->queryParams['PaymentMasterSearch'] : array();
      if (!empty($post_data)) {
        foreach ($post_data as $key => $value) {
          $exportParamData[$key]['value'] = $value;
        }
      }

    $gridColumns = [
           // ['class' => 'yii\grid\SerialColumn'],

            //'payment_id',
            //'date',
           [
              'attribute'=>'pickup_date',
              'headerOptions' => ['style' => 'width:10%'],

              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model['pickup_date'],'dd-MM-yy');
               },
                    /*'filter'=>DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'attribute' => 'pickup_date',
                    'model' => $searchModel,
                     //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                     'options' => [
                         'placeholder' => 'dd-mm-yyyy',
                     ],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'dd-mm-yyyy',
                         //'todayHighlight'=>true,
                     ]
                 ]),*/
            ],
                  [
              'attribute'=>'booking_id',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:15%'],

             /*'value' => function($model, $key, $index, $grid){
                 return Html::a( $model['customer_name'], ['booking/update','id' => $model['booking_id']], ['title' => 'View','class'=>'link_cust']);
                },*/
            ],
            [
              'attribute'=>'customer_name',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:15%'],

             /*'value' => function($model, $key, $index, $grid){
                 return Html::a( $model['customer_name'], ['booking/update','id' => $model['booking_id']], ['title' => 'View','class'=>'link_cust']);
                },*/
            ],

            [
              'attribute'=>'booking_date',
              'headerOptions' => ['style' => 'width:10%'],

              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model['booking_date'],'dd-MM-yyyy');
               },
                    /*'filter'=>DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'attribute' => 'pickup_date',
                    'model' => $searchModel,
                     //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                     'options' => [
                         'placeholder' => 'dd-mm-yyyy',
                     ],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'dd-mm-yyyy',
                         //'todayHighlight'=>true,
                     ]
                 ]),*/
            ],


              [
              'attribute'=>'return_date',
              'headerOptions' => ['style' => 'width:10%'],

              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model['return_date'],'dd-MM-yyyy');
               },
                    /*'filter'=>DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'attribute' => 'pickup_date',
                    'model' => $searchModel,
                     //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                     'options' => [
                         'placeholder' => 'dd-mm-yyyy',
                     ],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'dd-mm-yyyy',
                         //'todayHighlight'=>true,
                     ]
                 ]),*/
            ],
            [
              'attribute'=>'order_status',
              'format'=>'raw',

             'headerOptions' => ['style' => 'width:15%'],
             /*'group'=>true,
             'subGroupOf'=>1,*/
             /*'value' => function($model, $key, $index, $grid){
                 return Html::a( $model['customer_name'], ['booking/update','id' => $model['booking_id']], ['title' => 'View','class'=>'link_cust']);
                },*/
            ],



            [ 'attribute'=>'rent_amount',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Rent Amt.',

              'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),
                //'footer' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),

            ],
            [ 'attribute'=>'deposite_amount',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Depst. Amt.',

              //'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'deposite_amount'),
            ],
             [ 'attribute'=>'discount',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Discount',

             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'discount'),
            ],
         /*   [ 'attribute'=>'return_amount',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Return Amt.',
                 'group'=>true,
             'subGroupOf'=>1,
             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'return_amount'),
            ],*/
               [ 'attribute'=>'extra_amount',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Extra Amt.',

             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'extra_amount'),
            ],
            [ 'attribute'=>'cancellation_charges',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Cancellation Chrg.',

             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'cancellation_charges'),
            ],
            [ 'attribute'=>'other_charges',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Othr. Chrg.',

             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'other_charges'),
            ],
            [ 'attribute'=>'issues_penalty',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Penalty',

             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'issues_penalty'),
            ],
             [
                 //'attribute'=>'other_charges',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Total Earning',


             'value'=> function($model, $key, $index, $grid){
                 return (($model['rent_amount']-$model['discount']) +$model['cancellation_charges']+$model['extra_amount']+$model['other_charges']-$model['issues_penalty']);
             },
             // 'pageSummary' => true,
                'pageSummary' => PaymentMaster::getTotal($dataProvider->models, 'total_earn'),
            ],
            [ 'attribute'=>'cash_amount_reci',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Cash Recv',

                'xlFormat'=>'0',
               'pageSummary' => true,
                //'footer' => PaymentHeader::getTotal($dataProvider->models, 'amount'),
            ],
        [ 'attribute'=>'online_amount_recived',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'xlFormat'=>'Number',
                'header'=>'Online Reciv',
                /*'value'=> function($model, $key, $index, $grid){

               return ($model['type']=='Return-Payment' || $model['type']=='Return-Deposit')?($model['amount']*-1):0;
               },*/
                'pageSummary' => true,
                //'footer' => PaymentHeader::getTotal($dataProvider->models, 'amount'),
            ],
             [ 'attribute'=>'cash_amount_return',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'cash Retrn',
                /*'value'=> function($model, $key, $index, $grid){
                return ($model['type']=='Other-Charges' || $model['type']=='Cancel-Charge')?$model['amount']:0;
               },*/
               'pageSummary' => true,
                //'footer' => PaymentHeader::getTotal($dataProvider->models, 'amount'),
            ],

        [ 'attribute'=>'online_amount_return',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'xlFormat'=>'Number',
                'header'=>'Online Rtrn',
               /* 'value'=> function($model, $key, $index, $grid){

               return ($model['type']=='Return-Payment' || $model['type']=='Return-Deposit')?($model['amount']*-1):0;
               },*/
                'pageSummary' => true,
                //'footer' => PaymentHeader::getTotal($dataProvider->models, 'amount'),
            ],
        [ 'attribute'=>'online_amount_return',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'xlFormat'=>'Number',
                'header'=>'Transaction Total',
                'value'=> function($model, $key, $index, $grid){

               return ($model['cash_amount_reci'] +$model['online_amount_recived']) - ($model['cash_amount_return'] +$model['online_amount_return']);
               },
                'pageSummary' => true,
                //'footer' => PaymentHeader::getTotal($dataProvider->models, 'amount'),
            ],
        [
              'attribute' => 'view_level',

            ]
            //'booking_id',




        ];
    $fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'batchSize' => 1000,
    'target' => '_blank',
    'pjax' => true,
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_EXCEL => false,
        ExportMenu::FORMAT_PDF => false,
    ],
    //'folder' => '@webroot/tmp', // this is default save folder on server
        'exportFormHiddenInputs' => $exportParamData,
    'exportContainer' => [
      'class' => 'btn-group mr-2'
    ],
    'exportRequestParam'=>"PaymentMasterSearch=".json_encode($searchModel),
    'dropdownOptions' => [
        'label' => 'Export',
        'class' => 'btn btn-outline-secondary',
        'itemsBefore' => [
            '<div class="dropdown-header">Export All Data</div>',
        ],
    ],
  ]);

    echo GridView::widget([
       /* 'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar'=>[
        '{export}',
        '{toggleData}'
    ],*/
'autoXlFormat'=>true,
                'id' => 'kv-grid-demo',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'floatHeader'=>true,
                // 'showFooter' => true,
                'footerRowOptions'=>['style'=>'background-color:#f7f78b;'],
                'perfectScrollbar' => true,
                // 'showFooter' => true,
                // 'footerRowOptions'=>['style'=>'background-color:#F9F908;font-size:15px;font-weight:bold'],
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                'filterPosition' => \yii\grid\GridView::FILTER_POS_BODY,
                'containerOptions' => ['style' => 'overflow: auto'],
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
               /* 'rowOptions'   => function ($model, $key, $index, $grid) {
                    return ['data-company_code' => $model->COMPANY_CODE,'data-id' => $model->DOCUMENT_NO,'class' => 'td_row row_class row_class_'.$model->DOCUMENT_NO];
                },*/
                'containerOptions' => ['style' => 'overflow: auto'],
               /* 'pager' => [ // Scroll Grid
                    'class' => \kop\y2sp\ScrollPager::className(),
                    'container' => '.grid-view tbody',
                    'item' => 'tr',
                    'paginationSelector' => '.grid-view .pagination',
                    'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer" class="trigger_event">{text}</a></td></tr>',
                    'id'=>'pager_id',
                    'delay'=>0,
                    'enabledExtensions'=> ['IASSpinnerExtension'], //Only Spinner extension enabled
                    'eventOnNoneLeft' => 'recalculateFinalTotal', // Summary Calculation function
                    'eventOnLoaded' => 'scrollBodyTop', // Scrollbar to top
                    //'eventOnRendered' => 'registerJsFunction', //Register Js if  any
                    //'overflowContainer'=> '#gridview-gl-line-item-container',
                ],*/
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                //'columns' => $arrColumns,
                'showPageSummary' => true,
                'pageSummaryRowOptions' => ['style'=>'background:#F9F908;font-size:15px;font-weight:bold'],
                'pjax' => true,
                'pjaxSettings'=> [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'toolbar' =>  [
                    '{export}',
                   $fullExportMenu,
                ],
                'export' => [
                    'fontAwesome' => true
                ],
                'exportConfig' => [
                    GridView::PDF => ['label' => 'PDF', 'filename' => 'File_Name -'.date('d-M-Y'), 'config' => ['methods' => ['SetHeader' => array($this->title), 'SetFooter' => array('{PAGENO}')]]],
                    GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => $this->title.'-'.date('d-M-Y')],
                ],
                'panel' =>
                    [
                        'type' => GridView::TYPE_PRIMARY,
                        'before'=>'  
    <div class="pull-left report-back-btn-ar" style="margin-left:20px;">
      
    </div>
        <div style="text-align: center;font-size:16px;"><center><b>'. $this->title .'</center></b></div>
      ',   // <img src="img/icons/back-arrow.png" style="height:16px;cursor:pointer;" id="back_button" class="back-redirect-for-button">
                    ],
                'persistResize' => false,
                'toggleDataOptions' => ['minCount' => 10],

        'columns' => $gridColumns,
    ]); ?>


</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
  /*$(document).ready(function() {
    $('#example').DataTable();
} );*/
function set_month_filter() {
var month=$('#month').val();
var year=$('#year').val();
//alert("<?= Url::base(); ?>");
 window.location.href = "<?= Url::base(); ?>/index.php?r=payment/index&month="+month+"&year="+year;
}
   function show_grid_row(val){
      $('.row_class_'+val).show();
      $('#hide_row_'+val).hide();
      $('#show_row_'+val).show();
    }
    function hide_grid_row(val){
      $('.row_class_'+val).hide();
      $('#hide_row_'+val).show();
      $('#show_row_'+val).hide();
    }
</script>