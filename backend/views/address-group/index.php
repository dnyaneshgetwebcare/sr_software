<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AddressGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Address Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  td,th{
    font-size: 15px; 
}

</style>
<div class="address-group-index">

      <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Address Group</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Address Group</a></li>
                            <li class="breadcrumb-item active">Address Group</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                           
                             <button type="button" onclick="addnewItem()" class="btn btn-info pull-right">Add New </button>
                            <div class="">
                               
                            </div>
                        </div>
                    </div>
                </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',

              ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}',
          'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                ]);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil" onclick="open_update('.$model->id.')"></span>');
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                ]);
            }

          ],],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
</div>

</div>
<script type="application/javascript">
    function addnewItem() {

        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('address-group/create') ?>",
            type: 'post',
            dataType:'html',
            beforeSend: function(){
                $(".overlay").show();
            },
            complete: function(){
                $(".overlay").hide();
            },
            success: function (data) {
                // console.log(data);
                $('#pModal').modal('show');
                $('#modalContent').html(data);
            },
            error: function(jqXhr, textStatus, errorThrown ){
                // alert(errorThrown);
                if(errorThrown=='Forbidden'){
                    alert(YOU_DONT_HAVE_ACCESS);
                }
            }
        });
    }
        function open_update(type_id) {
        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('address-group/update') ?>",
            type: 'get',
            data:{
                id:type_id
               },
            dataType:'html',
            beforeSend: function(){
                $(".overlay").show();
            },
            complete: function(){
                $(".overlay").hide();
            },
            success: function (data) {
                // console.log(data);
               
                $('#pModal').modal('show');
                $('#modalContent').html(data);
            },
            error: function(jqXhr, textStatus, errorThrown ){
                // alert(errorThrown);
                if(errorThrown=='Forbidden'){
                    alert(YOU_DONT_HAVE_ACCESS);
                }
            }
        });
    }
</script>