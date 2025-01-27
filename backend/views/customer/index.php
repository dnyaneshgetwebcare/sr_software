<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer';

?>
<style type="text/css">
    td, th {
        font-size: 15px;
    }

    #example > tbody > tr > td, #example > tbody > tr > th {
        padding: 4px 10px !important;
    }
</style>

<div class="customer-master-index">

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Customer</a></li>
                <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">

                <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success pull-right']) ?>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-0">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => ['id' => 'example', 'class' => 'display nowrap table table-hover table-striped table-bordered'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                //'id',
                                'name',
                                'email_id:email',
                                'contact_nos',
                                'contact_nos_2',
                                'address',
                                //'reference',
                                //'reference_name',
                                //'created_date',
                                'cust_group',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
