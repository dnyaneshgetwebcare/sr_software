<?php

use yii\helpers\Html;
use backend\models\BookingItem;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookingHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
//$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  td,th{
    font-size: 15px; 
}
.td_row{
  display: none;
}
</style>
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<div class="booking-header-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

  <!--   <p>
        <?php // Html::a('Create Booking', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?= $this->title ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Order</a></li>
                            <li class="breadcrumb-item active"><?= $this->title ?></li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-l-10 hidden-md-down">
                                <div class="chart-text">
                                   <div class="col-md-12">
                                     <div class="form-group">
                                       <?php $month_array=array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"June","07"=>"July","08"=>"Aug","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec",);
                                       $year_array= range(date('Y')-5,date('Y')+1,1);
                                       $select_month=isset($_GET['month'])?$_GET['month']:date('m');
                                      // echo $select_month;die;
                                       $select_year=isset($_GET['year'])?$_GET['year']:date('Y');
                                       ?>
                                        <label class="control-label text-right col-md-2"></label> 
                                <div class="col-md-3"> 
                                       <select name="month" id='month' class="form-control">
                                          <option>Select Month</option>
                                         <?php foreach ($month_array as $key => $month) {
                                              ?> 
                                      <option value="<?= $key; ?>" <?= ($key==$select_month)?'selected':''; ?>><?= $month; ?>
                                      </option>
                                              <?php 
                                            } ?>
                                            
                                        </select>
                                    </div>
                                      <div class="col-md-3"> 
                                  <select name="year" id='year' class="form-control">
                                          <option>Select Month</option>
                                         <?php foreach ($year_array as $key => $year) {
                                              ?> 
                                      <option value="<?= $year; ?>" <?= ($year==$select_year)?'selected':''; ?>><?= $year; ?>
                                      </option>
                                              <?php 
                                            } ?>
                                            
                                        </select>
                                      </div>
                                      <div class="col-md-2"> 
                                        <button type="button" onclick="set_month_filter()"; class="btn btn-inverse">Apply</button>
                                      </div>
                                      <div class="col-md-2"> 
                                        <?= Html::a('Clear', ['sales-item'], ['class' => 'btn btn-success pull-right']) ?>
                                      </div>
                                  </div>
                                  </div>
                              </div>
                            </div>
                          
                            
                          
                        </div>
                    </div>
                </div>
<div class="card-group">
  <?php foreach ($booking_item_summmary as $key => $item_sum) {
    # code...
   ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3><?= number_format($item_sum['total_net_value']) ?></h3>
                                    <h6 class="card-subtitle"><?= isset($model_category[$item_sum['category_id']])?$model_category[$item_sum['category_id']]:'-'; ?></h6></div>
                               
                            </div>
                        </div>
                    </div>
                    
                
<?php } ?>

</div>


    <div class="row">
                    <div class="col-12" style="overflow: auto;">
                        <div class="card" style="width: 130%; ">
                            <div class="card-body">

<div class="table-responsive m-t-40">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
         'showFooter' => true,
             'rowOptions'   => function ($model, $key, $index, $grid) {
        return ['data-id' => $model->booking_id,'class' => 'td_row row_class row_class_'.$model->booking_id];
        },
       // 'floatHeader'=>true,
         //'tableOptions' => ['class' => 'table m-t-30 table-hover contact-list'],
         'tableOptions' => [ 'id' => 'example','class' => 'display nowrap table table-hover table-striped table-bordered','style'=>'height:200px;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','headerOptions' => ['style' => 'width:5%'],],
          [ 'attribute'=>'customer_name',
             'headerOptions' => ['style' => 'width:25%'],
             'format'=>'raw',
          'group'=>true,
           'groupFooter'=>function ($model, $key, $index, $widget) {
               $name = '#'.$model->booking_id.' - '.$model->booking->customer->name;
               $booking_id = $model->booking_id;
               return [
               'mergeColumns'=>[[2, 3]],
               'content'=>[
                 1 => "<span class='glyphicon glyphicon-triangle-right' id='hide_row_$booking_id' onclick='show_grid_row($booking_id)' style='font-size: 10px'></span><span class='glyphicon glyphicon-triangle-bottom' id='show_row_$booking_id' onclick='hide_grid_row($booking_id)' style='font-size: 10px;display: none'></span>".' <span style="font-family:Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif;font-weight: 400"><b>'.$name.'</b></span>',

              
                6=> GridView::F_SUM,
                7 => GridView::F_SUM,
                // 7 => GridView::F_SUM,
             
            ],
            'contentFormats'=>[
              6=> ['format'=>'number', 'decimals'=>2],
              7 => ['format'=>'number', 'decimals'=>2],
             // 7 => ['format'=>'number', 'decimals'=>2],
             
            ],
            'contentOptions'=>[
              1 => ['style'=>'font-variant:small-caps'],
              6=> ['style'=>'text-align:right'],
              7 => ['style'=>'text-align:right'],
             // 7 => ['style'=>'text-align:right'],
             
            ],
            'options' => ['class'=>'success','style'=>'font-weight:bold;']
          ];
        },
             'value' => function($model, $key, $index, $grid){
                 return Html::a('#'.$model->booking_id.' - '.$model->booking->customer->name, ['booking/update','id' => $model->booking_id], ['title' => 'View Invoice','class'=>'link_cust']);
                },
                'header'=>'Inv'
            ],
             
            [
              'attribute' => 'item.images',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Image',
                /* 'format' => 'image',
             'value'=>function($data) { return $data->imageurl; },*/
             'format' => 'html',
              'value' => function($data) { return '<a class="image-popup-vertical-fit" href="'.$data->item->imageurl.'">'.Html::img($data->item->imageurl, ['width'=>'100','height'=>'80']).'</a>'; },
              
            ],
            [ 
              'attribute'=>'product_id',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:15%'],
             'value' => function($model, $key, $index, $grid){
                 return Html::a( $model->item->name, ['item/update','id' => $model->product_id], ['title' => 'View','class'=>'link_cust']);
                },
            ],

  [
              'attribute' => 'item.category.name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Category',
              'filter'=>Html::activeDropDownList($searchModel, 'category_id',($model_category),['class'=>'form-control','prompt'=>'Select Category']),
            ],
            
               [
              'attribute' => 'item.type.name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Type',
              'filter'=>Html::activeDropDownList($searchModel, 'type_id',($type_master),['class'=>'form-control','prompt'=>'Select Type']),
            ],
               [ 'attribute'=>'earning_amount',
             'headerOptions' => ['style' => 'width:8%'],
             'format'=>['decimal',0],
             'footer' => BookingItem::getTotal($dataProvider->models, 'earning_amount'),
            ],
              [ 'attribute'=>'deposit_amount',
             'headerOptions' => ['style' => 'width:8%'],
             'format'=>['decimal',0],
             'header'=>'Deposite Amt',
             'footer' => BookingItem::getTotal($dataProvider->models, 'deposit_amount'),
            ],
           
            [
              'attribute'=>'pickup_date',
              'format' => 'html',
              'headerOptions' => ['style' => 'width:10%'],
              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model->pickup_date,'dd-MM-yyyy');
               },
                    'filter'=>DatePicker::widget([
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
                 ]),
            ],
         
          
           
          
           [ 'attribute'=>'item_status',
             'headerOptions' => ['style' => 'width:7%'],
             'filter'=>Html::activeDropDownList($searchModel, 'item_status',(array(''=>'Select','Booked'=>'Booked','Picked'=>'Picked','Pending'=>'Pending','Returned'=>'Returned')),['class'=>'form-control']),
            ],
            
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
 window.location.href = "<?= Url::base(); ?>/index.php?r=booking-item/sales-item&month="+month+"&year="+year;
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