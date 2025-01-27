<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\PurchaseHeader;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Headers';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  td,th{
    font-size: 15px; 
}

</style>
<div class="purchase-header-index">

       <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Purchase Item</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Purchase items</a></li>
                            <li class="breadcrumb-item active">Purchase Items</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            
                             <?= Html::a('Clear Filter', ['items-report'], ['class' => 'btn btn-success pull-right']) ?>
                           
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
         'showFooter' => true,
        
         //'tableOptions' => ['class' => 'table m-t-30 table-hover contact-list'],
         'tableOptions' => [ 'id' => 'example','class' => 'display nowrap table table-hover table-striped table-bordered'],
        'columns' => [
            

            [ 'attribute'=>'item_no',
             'headerOptions' => ['style' => 'width:5%'],
             'header'=>'#'
            ],
            [
              'attribute'=>'purchase_date_search',
               'label' => 'Date',
              'headerOptions' => ['style' => 'width:20%'],
              'value'=> function($model, $key, $index, $grid){
                return Yii::$app->formatter->asDate($model->purhcase->purchase_date,'dd-MM-yyyy');
               },
                    'filter'=>DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'attribute' => 'purchase_date_search',
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
            /* 'format' => 'image',
             'value'=>function($data) { return $data->imageurl; },*/
            [
              'attribute' => 'image',
              'headerOptions' => ['style' => 'width:20%'],
              'label' => 'Attachment',
                
             'format' => 'html',
              'value' => function($data) { return '<a class="image-popup-vertical-fit" href="'.$data->purhcase->imageurl.'">'.Html::img($data->purhcase->imageurl, ['width'=>'100','height'=>'80']).'</a>'; },
              
            ],
             [ 
              'attribute'=>'vendor_name',
              'format'=>'raw',
             'headerOptions' => ['style' => 'width:25%'],
             'value' => function($model, $key, $index, $grid){
                 return Html::a( $model->purhcase->vendor->name, ['purchase/update','id' => $model->purhcase_id], ['title' => 'View','class'=>'link_cust']);
                },
            ],

             [
              'attribute' => 'images',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Item Image',
                /* 'format' => 'image',
             'value'=>function($data) { return $data->imageurl; },*/
             'format' => 'html',
              'value' => function($data) { return '<a class="image-popup-vertical-fit" href="'.$data->item->imageurl.'">'.Html::img($data->item->imageurl, ['width'=>'100','height'=>'80']).'</a>'; },
              
            ],
             [
              'attribute' => 'item_name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Item Name',
              'value'=>'item.name',
            ],

            [
              'attribute' => 'item.category.name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Category',
              'filter'=>Html::activeDropDownList($searchModel, 'item_category',($model_category),['class'=>'form-control','prompt'=>'Select Category']),
            ],
            
               [
              'attribute' => 'item.type.name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Type',
              'filter'=>Html::activeDropDownList($searchModel, 'item_type',($type_master),['class'=>'form-control','prompt'=>'Select Type']),
            ],
              
             [ 'attribute'=>'net_value',
             'headerOptions' => ['style' => 'width:20%'],
             'format'=>['decimal',0],
             'footer' => PurchaseHeader::getTotal($dataProvider->models, 'net_value'),
            ],
           // 'purchase_date',
            //'purchase_amount',
           // 'discount',
            //'location',

            ['class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['style' => 'width:10%'],
          ],
        ],
    ]); ?>
</div>
</div>
</div>
</div>

</div>
