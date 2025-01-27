<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaction';

?>
<style type="text/css">
  td,th{
    font-size: 15px; 
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

   <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Current Month</a></li>
                            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card-group" style="margin-bottom: 30px">
  <?php 
$total_payment=0;
  foreach ($payment_summarys as $key => $item_sum) {
    # code...
    $total_payment+=$item_sum['total'];

   ?>
                    <div class="card">
                        <div class="card-body">
                           <div class="d-flex flex-row">
                                  <div class="round round-lg align-self-center round-info"><i class="mdi mdi-cellphone-link"></i></div>
                                  <div class="m-l-10 align-self-center">
                                    <h3>₹ <?= number_format($item_sum['total']) ?></h3>
                                    <h6 class="card-subtitle"><?= $item_sum['mode_of_payment'] ?></h6>
                                   </div>
                               
                            </div>
                        </div>
                    </div>      
<?php } ?>
<div class="card">
                        <div class="card-body">
                           <div class="d-flex flex-row">
                                  <div class="round round-lg align-self-center round-info"><i class="mdi mdi-cellphone-link"></i></div>
                                  <div class="m-l-10 align-self-center">
                                    <h3>₹ <?= number_format($total_payment) ?></h3>
                                    <h6 class="card-subtitle">Total Amount Receiver</h6>
                                   </div>
                               
                            </div>
                        </div>
                    </div> 

</div>

  <div class="row">
                    <div class="col-12" style="overflow: auto;">
                        <div class="card" style="width: 130%; ">
                            <div class="card-body">

<div class="table-responsive m-t-40">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'payment_id',
            //'date',
            [
              'attribute'=>'date',
              'headerOptions' => ['style' => 'width:10%'],
              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model->date,'dd-MM-yyyy');
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
            [ 
              'attribute'=>'customer_name',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:15%'],
             'value' => function($model, $key, $index, $grid){
                 return Html::a( $model->booking->customer->name, ['booking/update','id' => $model->booking_id], ['title' => 'View','class'=>'link_cust']);
                },
            ],
            [
              'attribute' => 'type',
              'headerOptions' => ['style' => 'width:15%'],
             // 'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'type',([''=>'Select', 'Advance' => 'Advance', 'Per-payment' => 'Per-payment', 'Deposit' => 'Deposit', 'Final-Payment' => 'Final-Payment', 'Return-Deposit' => 'Return-Deposit' ]),['class'=>'form-control']),
              
            ],
            [
              'attribute' => 'mode_of_payment',
              'headerOptions' => ['style' => 'width:5%'],
              'label' => 'Mode',
              'filter'=>Html::activeDropDownList($searchModel, 'mode_of_payment',([''=>'Select', 'Cash' => 'Cash', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other', ]),['class'=>'form-control']),
              
            ],
            [
              'attribute' => 'received_by',
              'headerOptions' => ['style' => 'width:10%'],
             // 'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'received_by',([''=>'Select', 'Varsha' => 'Varsha', 'Pranali' => 'Pranali', 'Others' => 'Others', ]),['class'=>'form-control']),
              
            ],
            [
              'attribute' => 'sendto',
              'headerOptions' => ['style' => 'width:5%'],
              //'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'sendto',([''=>'Select', 'Company' => 'Company', 'Pranali' => 'Pranali', 'Varsha' => 'Varsha', ]),['class'=>'form-control']),
              
            ],
         [
              'attribute' => 'received_during',
              'headerOptions' => ['style' => 'width:15%'],
             // 'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'received_during',([''=>'Select', 'Booking' => 'Booking', 'Pickup' => 'Pickup', 'Return' => 'Return', 'Other' => 'Other', ]),['class'=>'form-control']),
              
            ],
      /*   [
              'attribute' => 'sendto',
              'headerOptions' => ['style' => 'width:5%'],
              'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'payment_status',([ 'Company' => 'Company', 'Pranali' => 'Pranali', 'Varsha' => 'Varsha', ]),
              
            ],
         */
           
           
            //'received_during',
            
            //'dom',
            //'amount',
             [ 'attribute'=>'amount',
                'headerOptions' => ['style' => 'width:8%'],
                'format'=>['decimal',0],
                'header'=>'Amount',
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