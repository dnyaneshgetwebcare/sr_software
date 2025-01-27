<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ExpenseHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expense Headers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-header-index">

   <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Expense</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Create Expense</a></li>
                            <li class="breadcrumb-item active">Expense</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            
                             <?= Html::a('Create Expense', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                           
                        </div>
                    </div>
                </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">
                    <div class="col-12">
                        <div class="card" >
                            <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [ 'id' => 'example','class' => 'display nowrap table table-hover table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
             [ 
              'attribute'=>'id',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:25%'],
             'value' => function($model, $key, $index, $grid){
                 return Html::a('#'.$model->id, ['expense/update','id' => $model->id], ['title' => 'View','class'=>'link_cust']);
                },
            ],
            
            [
              'attribute'=>'expense_date',
              'headerOptions' => ['style' => 'width:20%'],
              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model->expense_date,'dd-MM-yyyy');
               },
                    'filter'=>DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'attribute' => 'expense_date',
                    'model' => $searchModel,                   
                     //'disabled' =>($readonly_GOODS_header)?$readonly_GOODS_header:$readonly_closed_string,
                     'options' => [
                         'placeholder' => 'dd-mm-yyyy',
                     ],
                     'pluginOptions' => [
                         'autoclose'=>true,
                         'format' => 'dd-mm-yyyy'
                     ]
                 ]),
            ],
            //'expense_type',
            'remark:ntext',
            'image_url:url',
           [ 'attribute'=>'name',
             'headerOptions' => ['style' => 'width:5%'],
             'header'=>'Vendor Name'
            ],
            [ 'attribute'=>'contact_nos',
             'headerOptions' => ['style' => 'width:5%'],
             'header'=>'Vendor Contact'
            ],
            //'vendor_id',
            //'name',
            //'contact_nos',
            //'address:ntext',
            //'delete_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
</div>
</div>
</div>
</div>
