<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reconcile Bank Transaction';

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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Payment</a></li>
                            <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
                        </ol>
                    </div>
               <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-l-10 hidden-md-down">
                                <div class="chart-text">
                                   <div class="col-md-12">
                                     <div class="form-group">
                                       <label class="control-label text-right col-md-2"></label> 
                              
                                      
                                  </div>
                                  </div>
                              </div>
                            </div>
                          
                            
                          
                        </div>
                    </div>
                </div>

    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['payment/reconcile-bank-transaction']]); ?>
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select Date</label>
                                <?php
                                $dateValue = isset($searchModel->date) && $searchModel->date != '' ? $searchModel->date : date('d-m-Y');
                                echo DatePicker::widget([
                                    'name' => 'PaymentMasterSearch[date]',
                                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                    'value' => $dateValue,
                                    'options' => [
                                        'placeholder' => 'dd-mm-yyyy',
                                        'class' => 'form-control',
                                        'id' => 'paymentmastersearch-date',
                                        'autocomplete' => 'off',
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'format' => 'dd-mm-yyyy'
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-top: 30px;">
                            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

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
                $date = is_array($model) ? (isset($model['date']) ? $model['date'] : '') : (isset($model->date) ? $model->date : '');
                return $date ? Yii::$app->formatter->asDate($date,'dd-MM-yyyy') : '';
               },
            ],
            [ 
              'attribute'=>'customer_name',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:18%'],
             'value' => function($model, $key, $index, $grid){
                 $customer_name = is_array($model) ? (isset($model['customer_name']) ? $model['customer_name'] : '') : (isset($model->customer_name) ? $model->customer_name : '');
                 $booking_id = is_array($model) ? (isset($model['booking_id']) ? $model['booking_id'] : null) : (isset($model->booking_id) ? $model->booking_id : null);
                 if($booking_id){
                     return Html::a( $customer_name, ['booking/update','id' => $booking_id], ['title' => 'View','class'=>'link_cust']);
                 }
                 return $customer_name;
                },
            ],
            [
              'attribute' => 'type',
              'headerOptions' => ['style' => 'width:12%'],
             // 'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'type',([''=>'Select', 'Advance' => 'Advance', 'Per-payment' => 'Per-payment', 'Deposit' => 'Deposit', 'Final-Payment' => 'Final-Payment', 'Cancel-Charge' => 'Cancel-Charge', 'Other-Charges' => 'Other-Charges']),['class'=>'form-control']),
              
            ],
            [
              'attribute' => 'mode_of_payment',
              'headerOptions' => ['style' => 'width:12%'],
              'label' => 'Mode',
              'filter'=>Html::activeDropDownList($searchModel, 'mode_of_payment',([''=>'Select', 'Google Pay' => 'Google Pay', 'Phone Pe' => 'Phone Pe', 'Bank Transfer' => 'Bank Transfer', 'Paytm' => 'Paytm', 'Other' => 'Other', 'Credit' => 'Credit']),['class'=>'form-control']),
              
            ],
            [
              'attribute' => 'sendto',
              'headerOptions' => ['style' => 'width:10%'],
              //'label' => 'Type of Payment',
              'filter'=>Html::activeDropDownList($searchModel, 'sendto',([''=>'Select', 'Company' => 'Company', 'Pranali' => 'Pranali', 'Varsha' => 'Varsha', ]),['class'=>'form-control']),
              
            ],
            [ 
              'attribute'=>'amount',
                'headerOptions' => ['style' => 'width:10%'],
                'format'=>['decimal',0],
                'header'=>'Amount',
                'value' => function($model, $key, $index, $grid){
                  return is_array($model) ? (isset($model['amount']) ? $model['amount'] : 0) : (isset($model->amount) ? $model->amount : 0);
                },
            ],
            [
              'attribute' => 'remark',
              'headerOptions' => ['style' => 'width:18%'],
              'format' => 'raw',
              'value' => function($model, $key, $index, $grid){
                return is_array($model) ? (isset($model['remark']) ? $model['remark'] : '') : (isset($model->remark) ? $model->remark : '');
              },
            ],
            
        ],
    ]); ?>


</div>
</div>
</div>
</div>
</div>

