<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PurchaseItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchase Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Purchase Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_no',
            'purhcase_id',
            'item_code',
            'net_value',
            'item_type',
            //'item_category',
            //'item_image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
