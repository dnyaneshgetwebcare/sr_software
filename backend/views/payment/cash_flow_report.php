<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
use backend\models\PaymentMaster;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daliy Summary';

?>
<style type="text/css">
  td,th{
    font-size: 12px; 
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
    <?php echo GridView::widget([
       /* 'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar'=>[
        '{export}',
        '{toggleData}'
    ],*/

                'id' => 'kv-grid-demo',
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
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

                    [
                        'content' =>
                            '<button class="search-button btn btn-default" onclick="search()" data-toggle ="tooltip" title="search"><i class="glyphicon glyphicon-search"></i></button>'
                    ],

                    '{export}',
                   // $fullExportMenu,
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
            
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'payment_id',
            //'date',
           
            [
              'attribute'=>'date',
               'header'=>'Payment Date',
              'headerOptions' => ['style' => 'width:5%'],
              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model['date'],'dd-MM-yy');
               },
                    'filter'=>DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'attribute' => 'date',
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
                 ]),
            ],

           
             
            [ 'attribute'=>'cash_rec',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Rec. Cash',
                // 'group'=>true,
           //  'subGroupOf'=>1,
              'pageSummary' => true,
                //'footer' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),
                
            ],
               [ 'attribute'=>'online_rec',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Rec. Online',
                // 'group'=>true,
           //  'subGroupOf'=>1,
              'pageSummary' => true,
                //'footer' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),
                
            ],
            
               [ 'attribute'=>'charge_on',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Extra',
                // 'group'=>true,
           //  'subGroupOf'=>1,
              'pageSummary' => true,
                //'footer' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),
                
            ],
            
               [ 'attribute'=>'cash_return',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Return Cash',
                // 'group'=>true,
           //  'subGroupOf'=>1,
              'pageSummary' => true,
                //'footer' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),
                
            ],
            [ 'attribute'=>'online_return',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Return Online',
                // 'group'=>true,
           //  'subGroupOf'=>1,
              'pageSummary' => true,
                //'footer' => PaymentMaster::getTotal($dataProvider->models, 'rent_amount'),
                
            ],
            [ 
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Balance Cash',
                'value'=> function($model, $key, $index, $grid){
                return $model['cash_rec']- $model['cash_return'];
               },
               'pageSummary' => true,
                //'footer' => PaymentHeader::getTotal($dataProvider->models, 'amount'),
            ],
          
            
            //'booking_id',

           

            
        ],
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