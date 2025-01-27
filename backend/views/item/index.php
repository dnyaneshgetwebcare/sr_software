<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  td,th{
    font-size: 15px; 
}
.form-control {
    font-size: 15px;
    font-weight: 150;
}
</style>
<div class="item-master-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Item', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p> -->
  <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Item Master</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Item</a></li>
                            <li class="breadcrumb-item active">Item Master</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <!-- <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div> -->
                             <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                          
                        </div>
                    </div>
                </div>
                 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="card-group">
  <?php foreach ($item_summary as $key => $item_sum) {
    # code...
   ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3><?= $item_sum['total_items'] ?></h3>
                                    <h6 class="card-subtitle"><?= isset($type_master[$item_sum['type_id']])?$type_master[$item_sum['type_id']]:'-'; ?></h6></div>
                               
                            </div>
                        </div>
                    </div>
                    
                
<?php } ?>

</div>
  <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive m-t-0">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [ 'id' => 'example','class' => 'display nowrap table table-hover table-striped table-bordered'],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
              'attribute' => 'images',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Image',
                /* 'format' => 'image',
             'value'=>function($data) { return $data->imageurl; },*/
             'format' => 'html',
              'value' => function($data) { return '<a class="image-popup-vertical-fit" href="'.$data->imageurl.'">'.Html::img($data->imageurl, ['width'=>'100','height'=>'80']).'</a>'; },
              
            ],
            'item_code',
            'name',
            'details',
            [
              'attribute' => 'category.name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Category',
              'filter'=>Html::activeDropDownList($searchModel, 'category_id',($model_category),['class'=>'form-control','prompt'=>'Select Category']),
            ],
            
               [
              'attribute' => 'type.name',
              'headerOptions' => ['style' => 'width:10%'],
              'label' => 'Type',
              'filter'=>Html::activeDropDownList($searchModel, 'type_id',($type_master),['class'=>'form-control','prompt'=>'Select Type']),
            ],
            
            'size',
            //'purchase_date',
            //'purchase_amount',
            //'rent_amount',
            //'deposit_amount',
            //'vendor_id',
            //'scrab_status',
            //'rent_times:datetime',
            //'expense_amount',
            'item_status',
            //'colour_cat',
            //'nos_dry_cleaning',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">

</script>